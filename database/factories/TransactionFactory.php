<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'       => User::factory(), // Creates a user and assigns their ID
            'type'          => fake()->randomElement(['deposit', 'withdrawal']),
            'amount'        => fake()->randomFloat(2, 10, 10000), // Amount between 10 and 10,000
            'balance_after' => fake()->randomFloat(2, 100, 50000), // Balance between 100 and 50,000
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }
}
