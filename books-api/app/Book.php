<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'description',
        'author_id',
    ];

    /**
     * Gets author of the book.
     */
    public function author() {
        return $this->belongsTo(Author::class);
    }
}
