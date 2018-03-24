<?php

namespace App\Repository;

use App\Entity\InsultVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class InsultVoteRepository
 * @package App\Repository
 *
 * @method findOneBy(array $criteria, array $orderBy = null): ?InsultVote
 */
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