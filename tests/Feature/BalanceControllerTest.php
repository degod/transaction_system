<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;

class BalanceControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $apiKey;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiKey = config('services.api_key');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_show_user_balance()
    {
        // Create a test user
        $user = User::factory()->create([
            'balance' => 100.00, // You can set the initial balance as needed
        ]);

        // Send a GET request to the balance endpoint with the X-API-KEY header
        $response = $this->withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->getJson(route('balance.show'));

        // Assert the response status and structure
        $response->assertStatus(200);
        $response->assertJson([
            'balance' => $user->balance,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_seed_database_if_no_user_exists()
    {
        // Ensure the database is empty
        $this->assertDatabaseCount('users', 0);

        // Mock the Artisan facade
        $this->seed(DatabaseSeeder::class);

        // Send a GET request to the balance endpoint with the X-API-KEY header
        $response = $this->withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->getJson(route('balance.show'));

        // Assert the response status
        $response->assertStatus(200);
    }
}
