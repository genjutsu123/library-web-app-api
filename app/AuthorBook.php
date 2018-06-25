<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuthorBook extends Model
{
    public $timestamps = false;
    protected $table = 'author_book';
    protected $fillable = [
        'book_id', 'author_id'
    ];
}
