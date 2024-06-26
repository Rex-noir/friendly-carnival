<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserSearch extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    public function test_can_search_users_by_id()
    {
        Role::factory()->count(3)->create();
        $user = User::factory()->create();
        $response = $this->post('/users/search', ['value' => $user->id]);

        $response->assertStatus(200);
        $response->assertSee($user->name);
    }

    public function test_can_search_users_by_name()
    {
        Role::factory(3)->create();
        $user = User::factory()->create(['name' => 'Linda']);
        $response = $this->post('/users/search', ['value' => $user->name]);

        $response->assertStatus(200);
        $response->dump();
        $response->assertSee($user->id);
    }
}
