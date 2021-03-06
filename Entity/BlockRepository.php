<?php

namespace Bigfoot\Bundle\ContentBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * BlockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlockRepository extends EntityRepository
{
    public function findByInstanceOf(QueryBuilder $queryBuilder, $data)
    {
        $queryBuilder
            ->where('e INSTANCE OF :className')
            ->setParameter(':className', $data);
    }
}
