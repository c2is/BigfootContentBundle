<?php

namespace Bigfoot\Bundle\ContentBundle\Entity\Page;

use Doctrine\ORM\EntityRepository;

/**
 * BlockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlockRepository extends EntityRepository
{
    public function findOneByPageBlock($page, $block)
    {
        return $this
            ->createQueryBuilder('b')
            ->where('b.page = :page')
            ->andWhere('b.block = :block')
            ->setParameter('page', $page)
            ->setParameter('block', $block)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
