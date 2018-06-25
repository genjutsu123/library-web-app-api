<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Genre extends Model
{
    use SoftDeletes;
    public static function boot(){
        Genre::deleting(function($data) {
            $data->Book()->delete();
        });
        Genre::restoring(function($data) {
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
