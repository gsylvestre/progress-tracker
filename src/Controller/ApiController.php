<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/tasks", name="list_all_tasks", methods={"GET"})
     */
    public function listAllTasks(TaskRepository $taskRepo, UserRepository $userRepo)
    {
        $tasks = $taskRepo->findBy([], ["sort" => "ASC"]);
        $users = $userRepo->findBy([], ['username' => 'ASC']);

        return $this->render('api/list_all_tasks.html.twig', [
            "tasks" => $tasks,
            "users" => $users,
        ]);
    }
}
