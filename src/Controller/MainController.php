<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        if ($this->getUser()){
            return $this->redirectToRoute("app");
        }

        return $this->render('main/home.html.twig', [

        ]);
    }
    /**
     * @Route("/app", name="app")
     */
    public function app()
    {
        return $this->render('main/app.html.twig', [

        ]);
    }

}
