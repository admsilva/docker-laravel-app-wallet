<?php

namespace Tests\Feature;


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

        $response = $this->get('/api/v1/wallets/1');

        $response->assertStatus(200);
    }
}
