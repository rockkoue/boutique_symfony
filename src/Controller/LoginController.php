<?php

namespace App\Controller;

use App\Form\LoginType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Translation\TranslatorInterface;

class LoginController extends AbstractController
{
    /**
     * @Route("/tex", name="login")
     */
    public function index(Request $request, \Swift_Mailer $mailer ,TranslatorInterface $translator)
    {
        $form = $this->createForm(LoginType::class);



        $message=$translator->trans('salute lamie');
        $form->handleRequest($request);

       if ($form->isSubmitted() && $form->isValid()) {

           $loginFormData = $form->getData();


           $message = (new \Swift_Message('You Got Mail!'))
                          ->setFrom($loginFormData['Email'])
                          ->setTo('playrockfashe@gmail.com')
                          ->setBody(
                              $loginFormData['Username'],
                              'text/plain'
                          )
                      ;
           
                      $mailer->send($message);
           
                      return $this->redirectToRoute('login');



           dump($loginFormData);

           // do something interesting here
       }
        return $this->render('login/index.html.twig',[
                       'our_form' => $form,
                       'our_form' => $form->createView(),
                   ]);
    }
}
