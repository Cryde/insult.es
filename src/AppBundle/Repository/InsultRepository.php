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
        $sq = $this
            ->getEntityManager()
            ->createQuery('SELECT i FROM AppBundle:Insult i WHERE i.id >= :rand')
            ->setParameters(['rand' => rand(0, $this->getMaxId())])
            ->setMaxResults(1);

        return $sq->getSingleResult();
    }

    /**
     * @return mixed
     */
    public function getMaxId()
    {
        return $this
            ->getEntityManager()
            ->createQuery('SELECT MAX(i.id) FROM AppBundle:Insult i')
            ->getSingleScalarResult();
    }
}
