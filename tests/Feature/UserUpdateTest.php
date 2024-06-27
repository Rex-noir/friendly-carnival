<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserUpdateTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function test_Update_user()
    {
        Role::factory()->count(3)->create();
        $user = User::factory()->create();

        $newData = ['email' => 'kaihpi@example.com'];

        $response = $this->put(route('users.update', $user->id), $newData);
        $response->assertStatus(200);
        $response->assertJson($newData);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'kaihpi@example.com', 'name' => $user->name]);
    }

    public function test_Update_Multiple()
    {
        Role::factory()->count(3)->create();
        $user = User::factory()->create();

        $newData = ['email' => 'kulikawn@example.com', 'name' => 'Suanga'];
        $response = $this->put(route('users.update', $user->id), $newData);
        $response->assertStatus(200);
        $response->assertJson($newData);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $newData['email'], 'name' => $newData['name']]);
    }
}
