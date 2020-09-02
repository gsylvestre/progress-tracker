<?php

namespace App\Controller;

use App\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(EntityManagerInterface $em)
    {
        /*
        for($i = 1; $i <= 9; $i++){
            $task = new Task();
            $task->setName("vidéo");
            $task->setDescription("J'ai regardé les vidéos du module $i");
            $task->setSort($i*10);
            $task->setModule($i);
            $em->persist($task);
            $em->flush();

            $task = new Task();
            $task->setName("tp");
            $task->setDescription("J'ai fini le TP du module $i");
            $task->setSort($i*10 + 5);
            $task->setModule($i);
            $em->persist($task);
            $em->flush();
        }
        */

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
