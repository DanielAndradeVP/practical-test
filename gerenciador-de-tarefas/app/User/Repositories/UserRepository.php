<?php

namespace App\User\Repositories;

use App\Models\User;

class UserRepository
{
    public function __construct(protected User $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        $this->model->create($data);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all()
    {
        return $this->model->paginate(20);
    }

    public function update($user, $data)
    {
        return $user->fill($data)->save();
    }

    public function delete($id)
    {
        $model = $this->model->find($id);

        return $model->delete();
    }
}
