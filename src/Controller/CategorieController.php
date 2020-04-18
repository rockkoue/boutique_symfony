<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(Request $request):Response
    {
        $cate= new Categorie();

        $form = $this->createForm(CategorieFormType::class, $cate);

        $form->handleRequest($request);

        date_default_timezone_set('Europe/Moscow');
        $date = date("Y-m-d H:i:s");
       
    if ($form->isSubmitted() && $form->isValid()) {
        $form->getData() ;// holds the submitted values
        // but, the original `$task` variable has also been updated
        $cate->setDateCreate($date);
        $cate = $form->getData();
        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cate);
         $entityManager->flush();

        return $this->redirectToRoute('categorie');
    }


        return $this->render('categorie/index.html.twig', [
            'form' => $form->createView(),
        ]);

       
    }
}
