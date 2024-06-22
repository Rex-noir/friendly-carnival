<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'role' => fake()->unique()->word(),
        ];
    }

    public function admin()
    {
        return $this->state(['role' => 'admin']);
    }

    public function editor()
    {
        return $this->state(['role' => 'editor']);
    }
    public function author()
    {
        return $this->state(['role' => 'author']);
    }
    public function user()
    {
        return $this->state(['role' => 'user']);
    }
}
