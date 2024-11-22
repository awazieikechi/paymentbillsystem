<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Transaction;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_transaction_create()
    {
        $user = User::factory()->create();

        $transactionData = [
            'user_id' => $user->id,
            'amount' => 80.00,
            'type' => 'deposit',
            'description' => 'Deposit from User',
        ];

        $response = $this->postJson('/api/v1/transactions', $transactionData);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'amount' => '80.00',
                'type' => 'deposit',
            ]);
    }

    public function test_transaction_get()
    {
        $response = $this->getJson("/api/v1/transactions/1");

        $response->assertStatus(200);
    }

   
}
