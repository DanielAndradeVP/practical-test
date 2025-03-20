<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\User\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {
        $this->service = $service;
    }

    public function store(UserRequest $request): JsonResponse
    {
        $request = $request->validated();

        $this->service->create($request);

        return $this->ok($request);
    }

    public function show($id): JsonResponse
    {
        return $this->ok($this->service->show($id));
    }

    public function listAllUsers(): JsonResponse
    {
        return $this->ok($this->service->listAllUsers());
    }

    public function update($id, UpdateUserRequest $request): JsonResponse
    {
        $request = $request->validated();

        $this->service->update($id, $request);

        return $this->ok($request);
    }

    public function delete($id): JsonResponse
    {
        return $this->ok($this->service->delete($id));
    }
}
