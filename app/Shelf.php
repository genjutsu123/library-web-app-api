<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Book;
class Shelf extends Model
{
    use SoftDeletes;
    public static function boot(){
        Shelf::deleting(function($data) {
            $data->Book()->delete();
        });
        Shelf::restoring(function($data) {
            $books = DB::table('books')->where('shelf_id',$data->id)->pluck('id');
            $books = Book::withTrashed()->find($books);
            $books->each(function ($item, $key){
                $author = DB::table('authors')->where('id',$item->author->id)->where('deleted_at',NULL)->exists();
                $genre = DB::table('genres')->where('id',$item->genre->id)->where('deleted_at',NULL)->exists();
                if($author && $genre){
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
