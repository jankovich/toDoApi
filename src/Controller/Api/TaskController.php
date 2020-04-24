<?php

namespace App\Controller\Api;

use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/api/list", methods={"GET"})
     */
    public function getList(): JsonResponse
    {
        $tasks = $this->taskRepository->findAll();

        $json =[];

        foreach ($tasks as $task) {
            $json[] = $task->getAsArray();
        }

        return new JsonResponse(['data' => $json]);
    }

    /**
     * @Route("/api/new", methods={"POST"})
     */
    public function new(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['name']) || empty($data['description'])) {
            return new JsonResponse(['status' => 'Missing required parameters'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->taskRepository->new($data['name'], $data['description']);

        return new JsonResponse(['status' => 'Task created'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/update/{id}", methods={"PUT"})
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['name']) || empty($data['description'])) {
            return new JsonResponse(['status' => 'Missing required parameters'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $task = $this->taskRepository->find($id);
        $task->setName($data['name']);
        $task->setDescription($data['description']);
        $task = $this->taskRepository->update($task);

        return new JsonResponse(['status' => 'Task updated', 'task' => $task->getAsArray()], Response::HTTP_OK);
    }

    /**
     * @Route("/api/done/{id}", methods={"PATCH"})
     */
    public function done(int $id)
    {
        $task = $this->taskRepository->find($id);
        $task->done();
        $task = $this->taskRepository->update($task);

        return new JsonResponse(['status' => 'Task updated', 'task' => $task->getAsArray()], Response::HTTP_OK);
    }
}