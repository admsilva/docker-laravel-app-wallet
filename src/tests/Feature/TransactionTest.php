<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\Wallet;
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

        $wallet = Wallet::first();

        $response = $this->get(sprintf('/api/v1/transactions/byWallet/%s', $wallet->id));

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

        $transaction = Transaction::first();

        $response = $this->get(sprintf('/api/v1/transactions/%s', $transaction->id));

        $response->assertStatus(200);
    }
}
