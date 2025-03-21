<?php

namespace Tests\Unit\Task;

use App\Models\Task;
use App\Models\User;
use App\Task\Services\TaskService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskUnitTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $taskService;

    private $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskService = app(TaskService::class);
        $this->user = User::factory()->create();

        $this->task = Task::factory()->create([
            'user_id' => $this->user->id,
        ]);

        auth()->login($this->user);
    }

    public function test_method_create_task(): void
    {
        $data = [
            'title' => fake()->title(),
            'description' => fake()->sentence(),
        ];

        $response = $this->taskService->create($data);

        $this->assertDatabaseHas('tasks', ['id' => $response->id]);
        $this->assertInstanceOf(Task::class, $response);
    }

    public function test_method_list_all_tasks(): void
    {
        $response = $this->taskService->listAllTasks();

        $this->assertCount(1, $response);
    }

    public function test_method_list_all_tasks_just_of_user(): void
    {
        Task::factory(2)->create();

        $response = $this->taskService->listAllTasks();

        $this->assertEquals($this->user->id, $response[0]->user_id);
        $this->assertCount(1, $response);
    }

    public function test_method_update_task(): void
    {
        $data = [
            'title' => 'fakeNameTask',
            'description' => fake()->sentence(),
        ];

        $this->taskService->update($this->task->id, $data);

        $this->assertDatabaseHas('tasks', ['title' => $data['title']]);
        $this->assertDatabaseMissing('tasks', ['title' => $this->task->title]);
    }

    public function test_method_delete_task(): void
    {
        $this->taskService->delete($this->task->id);

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }

    public function test_method_task_completed(): void
    {
        $this->task->completed = false;

        $this->taskService->taskCompleted($this->task->id);

        $this->assertDatabaseHas('tasks', ['completed' => true]);
    }

    public function test_method_validate_user_task(): void
    {
        $response = $this->taskService->validateTaskByUser($this->task->id);

        $this->assertInstanceOf(Task::class, $response);
    }

    public function test_method_validate_task_throw_exception_when_user_logged_is_not_owner(): void
    {
        $userTwo = User::factory()->create();

        $taskTwo = Task::factory()->create([
            'user_id' => $userTwo->id,
        ]);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Objeto não encontrado na base de dados');

        $this->taskService->validateTaskByUser($taskTwo->id);
    }

    public function test_method_validate_task_throw_exception_when_task_not_exists(): void
    {
        $fakeTaskId = fake()->randomNumber(2);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Objeto não encontrado na base de dados');

        $this->taskService->validateTaskByUser($fakeTaskId);
    }
}
