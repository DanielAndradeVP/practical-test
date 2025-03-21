<?php

namespace Tests\Unit\User;

use App\Models\User;
use App\User\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserUnitTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = app(UserService::class);
        $this->user = User::factory()->create();

        auth()->login($this->user);
    }

    public function test_method_create_user(): void
    {
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => 'Jujuba123+-',
        ];

        $entity = $this->userService->create($data);

        $this->assertDatabaseHas('users', ['id' => $entity->id]);
        $this->assertInstanceOf(User::class, $entity);
    }

    public function test_method_show_user(): void
    {
        $entity = $this->userService->show($this->user->id);

        $this->assertEquals($entity->id, $this->user->id);
        $this->assertInstanceOf(User::class, $entity);
    }

    public function test_method_list_all_users(): void
    {
        User::factory()->create();

        $response = $this->userService->listAllUsers();

        $this->assertCount(2, $response);
    }

    public function test_method_update_user(): void
    {
        $data = [
            'name' => fake()->name(),
            'email' => fake()->email(),
        ];

        $this->userService->update($this->user->id, $data);

        $this->assertDatabaseHas('users', ['name' => $data['name']]);
        $this->assertDatabaseMissing('users', ['name' => $this->user->name]);
    }

    public function test_method_delete_user(): void
    {
        $this->userService->delete($this->user->id);

        $this->assertDatabaseMissing('users', ['id' => $this->user->id]);
    }

    public function test_method_validate_user(): void
    {
        $entity = $this->userService->validateUser($this->user->id);

        $this->assertInstanceOf(User::class, $entity);
    }

    public function test_method_validate_user_throw_exception_when_is_not_user_logged(): void
    {
        $userTwo = User::factory()->create();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Objeto não encontrado na base de dados');

        $this->userService->validateUser($userTwo->id);
    }

    public function test_method_validate_user_throw_exception_when_user_not_exists(): void
    {
        $fakeUserId = fake()->randomNumber(2);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Objeto não encontrado na base de dados');

        $this->userService->validateUser($fakeUserId);
    }
}
