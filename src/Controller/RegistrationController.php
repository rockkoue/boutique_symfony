<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,\Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            //generation de token
            $user->setActivtionToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email


            

                            // On crée le message
                            $message = (new \Swift_Message('Nouveau compte'))
                            // On attribue l'expéditeur
                            ->setFrom('rockkoue@gmail.com')
                            // On attribue le destinataire
                            ->setTo($user->getEmail())
                            // On crée le texte avec la vue
                            ->setBody(
                                $this->renderView(
                                    'email/activation.html.twig',['token' => $user->getActivtionToken()]
                                ),
                                'text/html'
                            )
                            ;
                            $mailer->send($message);
           

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @route("/activation/{token}",name="activation")
     */
    public function activation($token,UserRepository $userRepository){

$user=$userRepository->findOneBy(['activtion_token'=>$token]);
//si aucun user existe avec ce token

if(!$user){
    
    throw $this->createNotFoundException('cet user n\'existe pas');

}

//on supprime le token

$user->setActivtionToken(null);
$entityManager=$this->getDoctrine()->getManager();
$entityManager->persist($user);
$entityManager->flush();

//messge flash

$this->addFlash('message','votre compte est bien active');


// On retourne à l'accueil
return $this->redirectToRoute('login');

    }



}
