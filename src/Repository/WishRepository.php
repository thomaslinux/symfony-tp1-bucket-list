<?php

namespace App\Repository;

use App\Entity\Wish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Wish>
 */
class WishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Wish::class);
    }


    public function findWishesByCategory($id = 1)
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->join('w.category', 'c')
            ->addSelect('c')
            ->andWhere('w.category = :categoryId')
            ->setParameter('categoryId', $id)
            ->andWhere('w.isPublished = :ispublished')
            ->setParameter('ispublished', true)
            ->addOrderBy('w.dateCreated', 'DESC');

        $query = $qb->getQuery();
        return $query->getResult();
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

    public function findWishesByTitle($wishTitle, $wishCategory)
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->join('w.category', 'c')
            ->addSelect('c')
            ->andWhere('w.isPublished = :ispublished')
            ->setParameter('ispublished', true);
        if ($wishTitle) {
            $qb
                ->andWhere($qb->expr()->like('w.title', ':wishTitle'))
                ->setParameter('wishTitle', '%' . $wishTitle . '%');
        }
        if ($wishCategory) {
            $qb
                ->andWhere('w.category = :categoryId')
                ->setParameter('categoryId', $wishCategory);
        }
        $qb
            ->addOrderBy('w.dateCreated', 'DESC');

        $query = $qb->getQuery();
        return $query->getResult();
    }


}
