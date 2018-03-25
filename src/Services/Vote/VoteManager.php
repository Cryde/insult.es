<?php

namespace App\Services\Vote;

use App\Entity\InsultVote;
use Doctrine\ORM\EntityManagerInterface;

class VoteManager
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * VoteManager constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param InsultVote $insultVote
     */
    public function persist(InsultVote $insultVote)
    {
        $this->entityManager->persist($insultVote);
    }

    public function flush()
    {
        $this->entityManager->flush();
    }
}
