<?php

namespace App\User\Services;

use App\User\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct(protected UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        $this->repository->create($data);
    }

    public function show($id)
    {
        $result = $this->repository->find($id);

        if (! $result) {
            throw new \Exception('Objeto não encontrado na base de dados');
        }

        return $result;
    }

    public function listAllUsers(): LengthAwarePaginator
    {
        return $this->repository->all();
    }

    public function update($id, $data)
    {
        $user = $this->validateUser($id);

        return $this->repository->update($user, $data);
    }

    public function delete($id)
    {
        $this->validateUser($id);

        return $this->repository->delete($id);
    }

    public function validateUser($id)
    {
        $entity = $this->repository->find($id);

        if (! $entity) {
            throw new \Exception('Objeto não encontrado na base de dados');
        }

        $entityId = $entity->getAttribute('id');

        $userLogged = auth()->user();

        $userId = $userLogged->getAttribute('id');

        if ($userId != $entityId) {
            throw new \Exception('Objeto não encontrado na base de dados');
        }

        return $entity;
    }
}
