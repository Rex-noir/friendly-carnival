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

    protected $adminUser;

    protected function  setUp(): void
    {
        parent::setUp();
        $admin = User::factory()->create(['role' => 'admin']);
        $this->adminUser = $admin;
    }


    public function test_Update_user()
    {
        $user = User::factory()->create();

        $newData = ['email' => 'kaihpi@example.com'];

        $response = $this->actingAs($this->adminUser)->put(route('users.update', $user->id), $newData);
        $response->assertStatus(204);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => 'kaihpi@example.com', 'name' => $user->name]);
    }

    public function test_Update_Multiple()
    {
        $user = User::factory()->create();

        $newData = ['email' => 'kulikawn@example.com', 'name' => 'Suanga'];
        $response = $this->actingAs($this->adminUser)->put(route('users.update', $user->id), $newData);
        $response->assertStatus(204);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'email' => $newData['email'], 'name' => $newData['name']]);
    }

    public function test_Update_status()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($this->adminUser)->post(route('users.ban', $user->id));
        $response->assertStatus(204);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 'banned']);
    }
}
