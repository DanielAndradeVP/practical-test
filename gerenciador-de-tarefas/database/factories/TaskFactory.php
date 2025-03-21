<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'user_id' => User::factory()->create()->id,
            'completed' => fake()->boolean(),
            'description' => fake()->sentence(),
        ];
    }
}
