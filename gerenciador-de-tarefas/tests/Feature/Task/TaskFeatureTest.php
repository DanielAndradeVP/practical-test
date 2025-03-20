<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    private $token;

    private $user;

    private $task;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = auth()->login($this->user);

        $this->task = Task::factory()->create([
            'user_id' => $this->user->id,
            'completed' => 0,
        ]);
    }

    public function test_if_can_create_task(): void
    {
        $data = [
            'title' => fake()->title(),
            'completed' => fake()->boolean(),
            'description' => fake()->text(),
        ];

        $this->postJson('api/task', $data, [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'type',
                'status',
                'data' => [
                    'title',
                    'description',
                ],
                'show',
            ]);
    }

    public function test_if_can_update_task(): void
    {
        $data = [
            'title' => fake()->sentence(),
        ];

        $this->putJson("api/task/{$this->task->id}", $data, [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'type',
                'status',
                'data',
                'show',
            ]);
    }

    public function test_if_can_delete_task(): void
    {
        $this->deleteJson("api/task/{$this->task->id}", [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk();

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }

    public function test_if_can_mark_task_as_completed(): void
    {
        $this->putJson("api/task/completed/{$this->task->id}", [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk();

        $this->assertDatabaseHas('tasks', ['completed' => 1]);
    }

    public function test_if_can_list_all_tasks_of_user(): void
    {
        Task::factory(2)->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->getJson('api/task', [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'type',
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '*' => [
                            'id',
                            'title',
                            'user_id',
                            'completed',
                            'description',
                        ],
                    ],
                ],
                'show',
            ]);

        $this->assertCount(3, $response['data']['data']);
    }
}
