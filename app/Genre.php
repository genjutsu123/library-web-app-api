<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Book;
class Genre extends Model
{
    use SoftDeletes;
    public static function boot(){
        Genre::deleting(function($data) {
            $data->Book()->delete();
        });
        Genre::restoring(function($data) {
            $books = DB::table('books')->where('genre_id',$data->id)->pluck('id');
            $books = Book::withTrashed()->find($books);
            $books->each(function ($item, $key){
                $author = DB::table('authors')->where('id',$item->author->id)->where('deleted_at',NULL)->exists();
                $shelf = DB::table('shelves')->where('id',$item->shelf->id)->where('deleted_at',NULL)->exists();
                if($author && $shelf){
                    $item->restore();
                }
            });
        });

    }
    protected $fillable = [
        'name'
    ];

    public function Book(){
        return $this->hasMany('App\Book');
    }

}
