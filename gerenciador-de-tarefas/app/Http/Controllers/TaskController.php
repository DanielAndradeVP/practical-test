<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Task\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(protected TaskService $service)
    {
        $this->service = $service;
    }

    public function store(TaskRequest $request): JsonResponse
    {
        $request = $request->validated();

        $this->service->create($request);

        return $this->ok($request);
    }

    public function listAllTasks(): JsonResponse
    {
        return $this->ok($this->service->listAllTasks());
    }

    public function update($id, UpdateTaskRequest $request): JsonResponse
    {
        $request = $request->validated();

        $this->service->update($id, $request);

        return $this->ok($request);
    }

    public function delete($id): JsonResponse
    {
        $response = $this->service->delete($id);

        return $this->ok($response);
    }

    public function taskCompleted($id): JsonResponse
    {
        $this->service->taskCompleted($id);

        return $this->ok('Tarefa completada com sucesso!');
    }
}
