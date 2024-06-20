<?php

use App\Models\Author;
use App\Models\Genre;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('isbn_10')->nullable();
            $table->string('isbn_13')->nullable();
            $table->date('publication_date')->nullable();
            $table->string('description')->nullable();
            $table->string('edition')->nullable();
            $table->string('language')->nullable();
            $table->string('cover_image')->nullable();
            $table->foreignIdFor(Author::class, 'author_id')->constrained()->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
