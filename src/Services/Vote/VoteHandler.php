<?php

namespace App\Services\Vote;

use App\Entity\Insult;
use App\Entity\InsultVote;

class VoteHandler
{
    /**
     * @var VoteFinder
     */
    private $voteFinder;
    /**
     * @var VoterHasher
     */
    private $voterHasher;
    /**
     * @var VoteManager
     */
    private $voteManager;

    /**
     * VoteHandler constructor.
     *
     * @param VoteFinder  $voteFinder
     * @param VoterHasher $voterHasher
     * @param VoteManager $voteManager
     */
    public function __construct(VoteFinder $voteFinder, VoterHasher $voterHasher, VoteManager $voteManager)
    {
        $this->voteFinder  = $voteFinder;
        $this->voterHasher = $voterHasher;
        $this->voteManager = $voteManager;
    }

    /**
     * @param Insult $insult
     * @param        $vote
     */
    public function handleVote(Insult $insult, $vote)
    {
        $voterHash  = $this->voterHasher->hash();
        $insultVote = $this->voteFinder->findByInsultAndVoterHash($insult, $voterHash);

        if (!$insultVote) {
            $this->newInsultVote($insult, $vote, $voterHash);
        } else {
            $this->existingInsultVote($insult, $insultVote, $vote);
        }

        $this->voteManager->flush();
    }

    /**
     * @param Insult $insult
     * @param        $vote
     * @param        $voterHash
     */
    private function newInsultVote(Insult $insult, $vote, $voterHash)
    {
        $insultVote = (new InsultVote())
            ->setInsult($insult)
            ->setVote($vote)
            ->setVoterHash($voterHash);

        $this->voteManager->persist($insultVote);

        if ($vote === 1) {
            $insult->setTotalVoteUp($insult->getTotalVoteUp() + 1);
        } else {
            $insult->setTotalVoteDown($insult->getTotalVoteDown() + 1);
        }
    }

    /**
     * @param Insult     $insult
     * @param InsultVote $insultVote
     * @param            $vote
     */
    private function existingInsultVote(Insult $insult, InsultVote $insultVote, $vote)
    {
        $previousVote = $insultVote->getVote();
        $insultVote->setVote($vote);

        if ($previousVote === $vote) {
            return;
        }

        if ($vote === 1) {
            $insult->setTotalVoteUp($insult->getTotalVoteUp() + 1);
            $insult->setTotalVoteDown($insult->getTotalVoteDown() - 1);
        } else {
            $insult->setTotalVoteDown($insult->getTotalVoteDown() + 1);
            $insult->setTotalVoteUp($insult->getTotalVoteUp() - 1);
        }
    }
}
