<?php

namespace App\Repository;

use App\Entity\ProduitLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProduitLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitLike[]    findAll()
 * @method ProduitLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitLike::class);
    }

    // /**
    //  * @return ProduitLike[] Returns an array of ProduitLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProduitLike
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
