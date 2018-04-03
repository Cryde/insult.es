<?php

use App\Entity\Insult;
use App\Entity\InsultVote;
use App\Repository\InsultVoteRepository;
use App\Services\InsultFormatter;
use App\Services\Vote\VoteFinder;
use App\Services\Vote\VoterHasher;
use PHPUnit\Framework\TestCase;

class InsultFormatterTest extends TestCase
{
    const MAP_IP_HASH = [
        '127.0.0.1' => 'a',
        '127.0.0.2' => 'b',
    ];

    public function testFormatWithNoVote()
    {
        $formatter = new InsultFormatter($this->buildVoteFinder('127.0.0.1'));

        $insult = (new Insult())
            ->setId(1)
            ->setInsult('value')
            ->setTotalVoteDown(20)
            ->setTotalVoteUp(40)
            ->setDatePost(DateTime::createFromFormat('d/m/Y H:i', '01/01/2000 12:00'));

        $result = $formatter->format($insult);

        $this->assertEquals(
            [
                'insult' => [
                    'id'              => 1,
                    'value'           => '#value',
                    'total_vote_up'   => 40,
                    'total_vote_down' => 20,
                    'total_vote'      => 60,
                    'current_vote'    => null,
                ],
            ],
            $result
        );
    }

    public function testFormatWithVote()
    {
        $formatter = new InsultFormatter($this->buildVoteFinder('127.0.0.2'));

        $insult = (new Insult())
            ->setId(1)
            ->setInsult('value2')
            ->setTotalVoteDown(5)
            ->setTotalVoteUp(10)
            ->setDatePost(DateTime::createFromFormat('d/m/Y H:i', '01/01/2000 12:00'));

        $result = $formatter->format($insult);

        $this->assertEquals(
            [
                'insult' => [
                    'id'              => 1,
                    'value'           => '#value2',
                    'total_vote_up'   => 10,
                    'total_vote_down' => 5,
                    'total_vote'      => 15,
                    'current_vote'    => 1,
                ],
            ],
            $result
        );
    }

    /**
     * @param $ip
     *
     * @return VoteFinder
     */
    private function buildVoteFinder($ip)
    {
        return new VoteFinder(
            $this->buildInsultVoteRepositoryMock(),
            $this->buildVoterHasher($ip)
        );
    }

    /**
     * @param $ip
     *
     * @return VoterHasher|\PHPUnit\Framework\MockObject\MockObject
     */
    private function buildVoterHasher($ip)
    {
        $mock = $this->getMockBuilder(VoterHasher::class)->disableOriginalConstructor()->getMock();

        $mock->expects($this->once())
             ->method('hash')
             ->willReturn(self::MAP_IP_HASH[$ip]);

        /** @var VoterHasher $mock */
        return $mock;
    }

    /**
     * @return InsultVoteRepository
     */
    private function buildInsultVoteRepositoryMock()
    {
        $mock = $this->getMockBuilder(InsultVoteRepository::class)->disableOriginalConstructor()->getMock();

        $mock->expects($this->once())
             ->method('findOneBy')
             ->willReturnCallback(
                 function ($param) {
                     if ($param['voterHash'] === 'b') {
                         return (new InsultVote())->setVote(1);
                     }

                     return null;
                 }
             );

        /** @var InsultVoteRepository $mock */
        return $mock;
    }
}
