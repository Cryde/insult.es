<?php

namespace App\Repository;

use App\Entity\InsultVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class InsultVoteRepository extends ServiceEntityRepository
{
    /**
     * InsultRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, InsultVote::class);
    }
}