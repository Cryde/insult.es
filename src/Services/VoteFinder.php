<?php

namespace App\Services;

use App\Entity\Insult;
use App\Entity\InsultVote;
use App\Repository\InsultVoteRepository;
use App\Services\VoterHasher;

class VoteFinder
{
    /**
     * @var VoterHasher
     */
    private $voterHasher;
    /**
     * @var InsultVoteRepository
     */
    private $insultVoteRepository;

    /**
     * VoterFinder constructor.
     *
     * @param InsultVoteRepository $insultVoteRepository
     * @param VoterHasher          $voterHasher
     */
    public function __construct(InsultVoteRepository $insultVoteRepository, VoterHasher $voterHasher)
    {
        $this->voterHasher          = $voterHasher;
        $this->insultVoteRepository = $insultVoteRepository;
    }

    /**
     * @param Insult $insult
     *
     * @return null|InsultVote
     */
    public function findByInsult(Insult $insult): ?InsultVote
    {
        return $this->findByInsultAndVoterHash($insult, $this->voterHasher->hash());
    }

    /**
     * @param Insult $insult
     * @param string $hash
     *
     * @return null|InsultVote
     */
    public function findByInsultAndVoterHash(Insult $insult, string $hash): ?InsultVote
    {
        return $this->insultVoteRepository->findOneBy(
            ['insult' => $insult, 'voterHash' => $hash]
        );
    }
}