<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'author_id',
        'genre_id',
        'shelf_id',
        'user_id',
        'name',
        'stock'
    ];

    public function Author() {
        return $this->belongsTo('App\Author');
    }

    public function Shelf() {
        return $this->belongsTo('App\Shelf');
    }

    public function Genre() {
        return $this->belongsTo('App\Genre');
    }

    public function  User() {
        return $this->belongsTo('App\User');
    }
}
