<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LangController extends AbstractController
{
    /**
     * @Route("/change-lang/{locale}", name="change-lang")
     */
    public function Changelang($locale, Request $request)
    {
        //stock de la lang dans la session
        $request->getSession()->set('_locale',$locale);
        $request->setLocale($locale);

        //retour sur la page precedante
        return $this->redirect($request->headers->get('referer'));
    }
}
