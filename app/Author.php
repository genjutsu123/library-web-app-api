<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    public static function boot() {
        Author::deleting(function($data) {
            $data->Book()->delete();
        });
        Author::restoring(function($data) {
            $data->Book()->restore();
            if($data->Book()->Genre()->exists() && $data->Book->Shelve->exists()) {
                
            }
        });
    }

    protected $fillable = [
        'name'
    ];

    public function Book() {
        return $this->hasMany('App\Book');
    }
}
