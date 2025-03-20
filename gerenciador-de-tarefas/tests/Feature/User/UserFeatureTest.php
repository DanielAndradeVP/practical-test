<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    private $token;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->token = auth()->login($this->user);
    }

    public function test_if_can_create_user(): void
    {
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => 'Jujuba123+-',
        ];

        $this->postJson('api/user', $data)
            ->assertOk()
            ->assertJsonStructure([
                'type',
                'status',
                'data' => [
                    'name',
                    'email',
                    'password',
                ],
                'show',
            ]);
    }

    public function test_if_can_show_user(): void
    {
        $this->getJson("api/user/{$this->user->id}", [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'type',
                'status',
                'data' => [
                    'id',
                    'name',
                    'email',
                ],
                'show',
            ]);
    }

    public function test_if_can_update_user(): void
    {
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
        ];

        $this->putJson("api/user/{$this->user->id}", $data, [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'type',
                'status',
                'data',
                'show',
            ]);

        $this->assertDatabaseHas('users', ['name' => $data['name']]);
    }

    public function test_if_can_delete_user(): void
    {
        $this->deleteJson("api/user/{$this->user->id}", [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk();

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }

    public function test_if_can_list_all_users(): void
    {
        User::factory()->create();

        $response = $this->getJson('api/user', [
            'Authorization' => 'Bearer '.$this->token,
        ])
            ->assertOk()
            ->assertJsonStructure([
                'type',
                'status',
                'data' => [
                    'current_page',
                    'data' => [
                        '0' => [
                            'id',
                            'name',
                            'email',
                        ],
                        '1' => [
                            'id',
                            'name',
                            'email',
                        ],
                    ],
                ],
                'show',
            ]);

        $this->assertCount(2, $response['data']['data']);
    }
}
