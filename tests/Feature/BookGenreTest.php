<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Genre;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookGenreTest extends TestCase
{

    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();

        // Run the migrations...
        $this->artisan('migrate');
    }

    public function test_book_has_genres()
    {
        $book = Book::factory()->create();
        $genres = Genre::factory()->count(3)->create();
        $book->genres()->attach($genres);
        $this->assertEquals(3, $book->genres->count());
    }

    public function test_genre_has_books()
    {
        $genre = Genre::factory()->create();
        $books = Book::factory()->count(3)->create();

        $genre->books()->attach($books);

        $this->assertEquals(3, $genre->books->count());
    }
}
