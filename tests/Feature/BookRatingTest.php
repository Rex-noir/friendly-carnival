<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Rating;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookRatingTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    public function test_can_add_rating_to_a_book()
    {
        $book = Book::factory()->create();
        $rating = Rating::factory()->make(['rating' => 5]);

        $book->ratings()->save($rating);

        $this->assertDatabaseHas('ratings', ['book_id' => $book->id, 'rating' => 5]);
        $this->assertTrue($book->ratings->contains($rating));
    }

    public function test_book_in_the_rating()
    {
        // Create a rating with a associated book
        $rating = Rating::factory()->create();

        // Assert that the book method returns a valid instance of Book
        $this->assertInstanceOf(Book::class, $rating->book);
    }

    public function test_avg_ratings_of_the_book()
    {
        $book = Book::factory()->create();

        $rating = Rating::factory()->make(['rating' => 5]);

        $book->ratings()->save($rating);

        $this->assertEquals(5, $book->averageRating());
    }
}
