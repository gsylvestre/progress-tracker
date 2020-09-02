<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

        $tasksByModule = [];
        foreach($tasks as $task){
            $tasksByModule[$task->getModule()][] = $task;
        }

        return $this->render('api/list_all_tasks.html.twig', [
            "tasks" => $tasksByModule,
            "users" => $users,
        ]);
    }

    /**
     * @Route("/tasks/setLastDoneTask", name="set_last_done_task", methods={"POST"})
     */
    public function setLastDoneTask(EntityManagerInterface $em, TaskRepository $taskRepo, Request $request)
    {
        $user = $this->getUser();
        $json = $request->getContent();
        $data = json_decode($json);
        $taskId = $data->taskId;

        if (!$user || !$taskId){
            throw $this->createAccessDeniedException();
        }

        $task = $taskRepo->find($taskId);
        if (!$task){
            throw $this->createNotFoundException();
        }

        $user->setLastDoneTask($task);
        $em->persist($user);
        $em->flush();

        return new JsonResponse("ok");
    }
}
