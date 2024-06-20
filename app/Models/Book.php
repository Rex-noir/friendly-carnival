<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'isbn_10',
        'isbn_13',
        'author_id',
        'publication_date'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
