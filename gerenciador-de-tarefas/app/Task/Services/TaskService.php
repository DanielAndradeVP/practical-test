<?php

namespace App\Task\Services;

use App\Task\Repositories\TaskRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskService
{
    public function __construct(protected TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $userLogged = auth()->user();

        return $this->repository->create($data, $userLogged);
    }

    public function listAllTasks(): LengthAwarePaginator
    {
        $userLogged = auth()->user();

        return $this->repository->all($userLogged->id);
    }

    public function update($id, $data)
    {
        $entity = $this->validateTaskByUser($id);

        $this->repository->update($entity, $data);

        return $entity;
    }

    public function delete($id)
    {
        $this->validateTaskByUser($id);

        return $this->repository->delete($id);
    }

    public function validateTaskByUser($id)
    {
        $entity = $this->repository->find($id);

        if (! $entity) {
            throw new \Exception('Objeto não encontrado na base de dados');
        }

        $userLogged = auth()->user();

        $userId = $userLogged->getAttribute('id');

        if ($userId != $entity->user->id) {
            throw new \Exception('Objeto não encontrado na base de dados');
        }

        return $entity;
    }

    public function taskCompleted($id)
    {
        $entity = $this->validateTaskByUser($id);

        return $this->repository->taskCompleted($entity);
    }
}
