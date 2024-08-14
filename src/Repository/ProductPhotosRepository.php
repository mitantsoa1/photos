<?php

namespace App\Repository;

use App\Entity\ProductPhotos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductPhotos>
 */
class ProductPhotosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPhotos::class);
    }

    /**
     * @return ProductPhotos[] Returns an array of ProductPhotos objects
     */
    public function findByProduct($product): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.productId = :val')
            ->setParameter('val', $product)
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?ProductPhotos
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
