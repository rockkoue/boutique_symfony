<?php

namespace App\Repository;

use App\Entity\ProduitSearch;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method ProduitSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitSearch[]    findAll()
 * @method ProduitSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitSearch::class);
    }

     /**
      * @return array Returns an array of ProduitSearch objects
      */
    public function findSearch( ProduitSearch $search ): array
    {

        //$query= $this->findAllVisibleQuery();
        $query=$this->createQueryBuilder('p')
                    ->select('c','p')
                    ->join('p.categorie','c');

        if($search->getNomProduit())
        {
            $query =$query
                    ->andwhere('produit','p.nomProduit')
                    ->setParameter('produit',$search->getNomProduit());
        }

        if($search->getNomCategorie())
        {
            $query =$query
                    ->andwhere('categorie','p.nomCategorie')
                    ->setParameter('categorie',$search->getNomCategorie());
        }

        return  $query->getQuery()->getResult();

    }
    
}
