<?php

namespace AppBundle\Repository;

/**
 * InsultRepository
 *
 */
class InsultRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @return mixed
     */
    public function getRandom()
    {
        return  $this->createQueryBuilder('i')
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }
}
