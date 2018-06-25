<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelf extends Model
{
    use SoftDeletes;
    public static function boot(){
        Shelf::deleting(function($data) {
            $data->Book()->delete();
        });
        Shelf::restoring(function($data) {
            $data->Book()->restore();
        });

    }
    protected $fillable = [
        'name'
    ];
    public function Book(){
        return $this->hasMany('App\Book');
    }



}
