<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookShelve extends Model
{
    public $timestamps = false;
    protected $table = 'book_shelf';
    protected $fillable = [
        'book_id', 'shelf_id'
    ];


}
