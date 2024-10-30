<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $apiKey;

    protected function setUp(): void
    {
        parent::setUp();
        $this->apiKey = config('services.api_key');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_seed_database_if_no_user_exists()
    {
        // Ensure the database is empty
        $this->assertDatabaseEmpty('users');
        // Mock the Artisan facade
        $this->seed(DatabaseSeeder::class);
        // Send a POST request to the transaction endpoint
        $response = $this->withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->postJson(route('transaction.store'), [
            'type'   => 'deposit',
            'amount' => 100,
        ]);
        // Assert the response status
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_prevents_duplicate_recent_transactions()
    {
        // Create a user and a recent transaction
        $user = User::factory()->create();
        Transaction::create([
            'user_id'       => $user->id,
            'type'          => 'deposit',
            'amount'        => 100,
            'balance_after' => $user->balance + 100,
            'trx_reference' => 'unique-reference-123',
            'created_at'    => now(), // Ensure the transaction is recent
        ]);
        // Send a POST request to the transaction endpoint
        $response = $this->withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->postJson(route('transaction.store'), [
            'type'   => 'deposit',
            'amount' => 100,
        ]);
        // Assert the response status and error message
        $response->assertStatus(409)
            ->assertJson(['error' => 'Transaction already exists within the last minute']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_creates_a_transaction_successfully()
    {
        // Create a user with initial balance
        $user           = User::factory()->create(['balance' => 200]);
        $initialBalance = $user->balance;
        // Send a POST request to the transaction endpoint
        $response = $this->withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->postJson(route('transaction.store'), [
            'type'   => 'withdrawal',
            'amount' => 100,
        ]);
        // Assert the response status and check the transaction data
        $response->assertStatus(200);
        $this->assertDatabaseHas('transactions', [
            'user_id'       => $user->id,
            'type'          => 'withdrawal',
            'amount'        => 100,
            'balance_after' => $initialBalance - 100,
        ]);
        // Verify user balance was updated
        $this->assertEquals($initialBalance - 100, $user->fresh()->balance);
    }

    # [\PHPUnit\Framework\Attributes\Test]
    public function it_returns_error_if_insufficient_balance()
    {
        // Create a user with low balance
        $user           = User::factory()->create(['balance' => 50]);
        $initialBalance = $user->balance;

        // Send a POST request to the transaction endpoint
        $response = $this->withHeaders([
            'X-API-KEY' => $this->apiKey,
        ])->postJson(route('transaction.store'), [
            'type'   => 'withdrawal',
            'amount' => 100,
        ]);

        // Assert the response status and error message
        $response->assertStatus(422)
            ->assertJson(['error' => 'Insufficient balance']);

        // Verify balance remained unchanged
        $this->assertEquals($initialBalance, $user->fresh()->balance);

        // Verify no transaction was created
        $this->assertDatabaseCount('transactions', 0);
    }
}
