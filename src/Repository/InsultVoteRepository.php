<?php

namespace App\Repository;

use App\Entity\InsultVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

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
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InsultVote::class);
    }
}
