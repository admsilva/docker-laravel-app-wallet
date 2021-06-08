<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test list all transactions by wallet id.
     *
     * @return void
     */
    public function test_list_all_transactions_by_wallet_id(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/transactions/byWallet/1');

        $response->assertStatus(200);
    }

    /**
     * Test get transaction by id.
     *
     * @return void
     */
    public function test_list_transaction_by_id(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/transactions/1');

        $response->assertStatus(200);
    }
}
