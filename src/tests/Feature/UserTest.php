<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test list all users.
     *
     * @return void
     */
    public function test_list_all_users(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/users');

        $response->assertStatus(200);
    }

    /**
     * Test get user by id.
     *
     * @return void
     */
    public function test_list_user_by_id(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/users/1');

        $response->assertStatus(200);
    }
}
