<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
            'author_id' => AuthorFactory::new()->create(),
            'publication_date' => fake()->date()
        ];
    }

    // public function configure()
    // {
    //     return $this->afterCreating(function (Book $book) {
    //         $genres = DB::table('genres')->inRandomOrder()->take(rand(1, 10))->pluck('id');
    //         $book->genres()->attach($genres);
    //     });
    // }
}
