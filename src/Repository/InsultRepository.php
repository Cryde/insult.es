<?php

namespace App\Repository;

use App\Entity\Insult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * InsultRepository
 *
 */
class InsultRepository extends ServiceEntityRepository
{
    /**
     * InsultRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
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
