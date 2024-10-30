<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'uuid'              => fake()->unique()->safeEmail(),
            'balance'           => fake()->randomFloat(2, 10, 10000),
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}
