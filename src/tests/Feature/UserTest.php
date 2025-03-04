<?php

namespace Tests\Feature;

use App\Models\User;
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

       $user = User::first();

        $response = $this->get(sprintf('/api/v1/users/%s', $user->id));

        $response->assertStatus(200);
    }
}
