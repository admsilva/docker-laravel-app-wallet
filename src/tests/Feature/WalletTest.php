<?php

namespace Tests\Feature;

use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test list all wallets.
     *
     * @return void
     */
    public function test_list_all_wallets(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/wallets');

        $response->assertStatus(200);
    }

    /**
     * Test get wallet by id.
     *
     * @return void
     */
    public function test_list_wallet_by_id(): void
    {
        $this->seed();

        $wallet = Wallet::first();

        $response = $this->get(sprintf('/api/v1/wallets/%s', $wallet->id));

        $response->assertStatus(200);
    }
}
