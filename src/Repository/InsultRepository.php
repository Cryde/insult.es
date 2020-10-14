<?php

namespace App\Repository;

use App\Entity\Insult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * InsultRepository
 *
 */
class InsultRepository extends ServiceEntityRepository
{
    /**
     * InsultRepository constructor.
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Insult::class);
    }

    /**
     * @return mixed
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRandom()
    {
        return $this->createQueryBuilder('i')
                    ->addOrderBy('RAND()')
                    ->setMaxResults(1)
                    ->getQuery()
                    ->getSingleResult();
    }
}
