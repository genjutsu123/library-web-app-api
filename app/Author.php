<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Book;
class Author extends Model
{
    use SoftDeletes;

    public static function boot() {
        Author::deleting(function($data) {
            $data->Book()->delete();
        });
        Author::restoring(function($data) {
            $books = DB::table('books')->where('author_id',$data->id)->pluck('id');
            $books = Book::withTrashed()->find($books);
            $books->each(function ($item, $key){
                $shelf = DB::table('shelves')->where('id',$item->shelf->id)->where('deleted_at',NULL)->exists();
                $genre = DB::table('genres')->where('id',$item->genre->id)->where('deleted_at',NULL)->exists();
                if($shelf && $genre){
                    $item->restore();
                }
            });

//            $data->book->each( function ($item, $key){
//                $item['shelf'] = $item->shelf;
//                $item['author'] = $item->author;
//                $item['genre'] = $item->genre;
//                log::info($item);
//            });
//            if($data->Book()->Genre()->exists() && $data->Book()->Shelve()->exists()) {
//                dd("BITCH");
//            }
//            $data->Book()->restore();


        });
    }

    protected $fillable = [
        'name'
    ];

    public function Book() {
        return $this->hasMany('App\Book');
    }
}
