<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Produits;
use App\Data\SearchData;
use App\Form\formSearch;
use App\Form\ProduitsType;
use App\Entity\ProduitLike;
use App\Entity\ProduitSearch;
use App\Form\ProduitSearchType;
use App\Repository\ProduitsRepository;
use App\Repository\ProduitLikeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Class produitcontroller
 * @package App\Controller
 * @Route("/produits", name="articles")
 */
class ProduitsController extends AbstractController
{

    /**
     * @Route("/", name="produit")
     */
    public function index(Request $request,ProduitsRepository $ripo ):Response
    {
        $search = new SearchData();

        $form=$this->createForm(formSearch::class,$search);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $produits= $ripo->findSearch($search);
            //dd($produits);
        }


         // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
         $produits = $this->getDoctrine()->getRepository(Produits::class)->findBy([],['date_creation' => 'desc']);
     
        return $this->render('produits/index.html.twig',
        [
            'current_menu'=>'produits',
            'produits'=>$produits,
            'form' =>$form->createView()
        ]);
    }
    /**
    * @Route("/details/{id}", name="product_show")
    */
   public function show($id)
   {
       $product = $this->getDoctrine()->getRepository(Produits::class)->find($id);
       
       if (!$product) {
           throw $this->createNotFoundException(
               'No product found for id '.$id
           );
       }
    
       //return new Response('Check out this great product: '.$product->getName());
   
       // or render a template
       // in the template, print things with {{ product.name }}
        return $this->render('produits/show.html.twig', [
            'product' => $product
            ]
        );
   }
   /**
    * @Route("/edit/{id}", name="product_edit")
    */
    public function edit($id)
    {
        $product = $this->getDoctrine()->getRepository(Produits::class)->find($id);
        
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
     
        //return new Response('Check out this great product: '.$product->getName());
    
        // or render a template
        // in the template, print things with {{ product.name }}
         return $this->render('produits/edit.html.twig', [
             'product' => $product
             ]
         );
    }

   

    /**
     * @Route("/create", name="create_product")
     */
    public function create(Request $request ):Response
    {
        $produit =new Produits();
        $form=$this->createForm(ProduitsType::class,$produit);

        $form->handleRequest($request);

        date_default_timezone_set('Europe/Moscow');
        $date = date("Y-m-d H:i:s");
       
    if ($form->isSubmitted() && $form->isValid()) {

            
                        //$item->setImage($fileName);

        $form->getData() ;// holds the submitted values
        // but, the original `$task` variable has also been updated
        $produit->setDateCreation($date);
        $produit = $form->getData();
 
        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
       $entityManager = $this->getDoctrine()->getManager();
      
         $entityManager->persist($produit);
         $entityManager->flush();
         //dd($d);
        return $this->redirectToRoute('produit');
    }

        
        return $this->render('produits/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * like or dislike
     *
     * @Route("/produits/{id}/like",name="produit_like")
     * 
     * @param Produits $produit
     * @param ObjectManager $manager
     * @param ProduitLikeRepository $ripo
     * @return Response
     */
public function like(Produits $produit ,ProduitLikeRepository $ripo) : Response 
{
    $user = $this->getUser();
       
    $manager = $this->getDoctrine()->getManager();

    if(!$user){
        return $this->json([
            'status'  => 403,
            'message'=>'pas connu'
        ],403);
            
    }
    if($produit->islikedByUser($user))
    {
             
        $like= $ripo->findOneBy([
           
            'produit' => $produit,
            'user'=>$user
        ]);          
            
            $manager->remove($like);
            $manager->flush();
        return $this->json([
            'code'=>200,
            'message'=>'like bien suprimé',
            'likes'=>$ripo->count(['produit'=>$produit])
        ],200);
    }
    
    $like=new ProduitLike();

    $like->setProduit($produit)
         ->setUser($user);

    $manager->persist($like);
        $d = $manager->flush();

      
    return $this->json([
            'code' => 200,
            'message' => 'like bien ajouter',
            'likes' => $ripo->count(['produit' => $produit])
    ],200);
}
    
}
