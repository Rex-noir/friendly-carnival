<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
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
            'title' => fake()->words(10, true),
            'isbn_10' => fake()->isbn10(),
            'isbn_13' => fake()->isbn13(),
            'author_id' => AuthorFactory::new()->create()
        ];
    }
}
