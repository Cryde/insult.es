<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * InsultRepository
 *
 */
class InsultRepository extends EntityRepository
{
    /**
     * @return mixed
     */
    public function getRandom()
    {
        return $this->createQueryBuilder('i')
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}
