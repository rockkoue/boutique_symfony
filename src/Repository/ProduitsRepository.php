<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Produits;
use App\Entity\formSearch ;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Produits|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produits|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produits[]    findAll()
 * @method Produits[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produits::class);
    }

    /**
     * @return Produits[] Returns an array of ProduitSearch objects
     */
    public function findSearch( SearchData $search): array
    {

        //$query= $this->findAllVisibleQuery();
        $query = $this->createQueryBuilder('q')
            ->select('c','q')
            ->join('q.categorie','c');

        if ($search->p) {
          
            $query = $query
                ->andwhere('q.libelle_produit LIKE :p')
                ->setParameter('p',"%{$search->p}%");
        }
        if ($search->categorie) {
           
            $query1 = $query
                ->andwhere('c.id IN(:categorie)')
                ->setParameter('categorie',"%{$search->categorie}%");
            dd($query1);
        }

        
      
        return  $query->getQuery()->getResult();
    }

    // /**
    //  * @return Produits[] Returns an array of Produits objects
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
    public function findOneBySomeField($value): ?Produits
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
