<?php

namespace App\Task\Repositories;

use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository
{
    public function __construct(protected Task $model)
    {
        $this->model = $model;
    }

    public function create(array $data, $userLogged)
    {
        $dataMerge = array_merge($data, ['user_id' => $userLogged->id]);

        $this->model->create($dataMerge);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function all($userId): LengthAwarePaginator
    {
        return $this->model
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->paginate(20);
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

    public function taskCompleted($entity)
    {
        $entity->completed = true;

        return $entity->save();
    }
}
