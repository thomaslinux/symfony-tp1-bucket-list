<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Wish>
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }


    public function findWishesWithCategory()
    {

        $qb = $this->createQueryBuilder('w');
        $qb
            ->join('w.category', 'c')
            ->addSelect('c')
            ->andWhere('w.isPublished = :ispublished')
            ->setParameter('ispublished', true)
            ->addOrderBy('w.dateCreated', 'DESC');

        $query = $qb->getQuery();
        return $query->getResult();
    }


}
