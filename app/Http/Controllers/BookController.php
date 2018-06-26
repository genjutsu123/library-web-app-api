<?php

namespace App\Http\Controllers;

use App\Author;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Book;
use App\BookUser;
use Validator;
class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::where('deleted_at',NULL)->where('stock', '>', 0)->get();
        $books->each( function ($item, $key){
            $item['shelf'] = $item->shelf;
            $item['author'] = $item->author;
            $item['genre'] = $item->genre;
        });
        return response()->json($books);
    }

    public function librarian()
    {
        $books = Book::where('deleted_at',NULL)->get();
        $books->each( function ($item, $key){
            $item['shelf'] = $item->shelf;
            $item['author'] = $item->author;
            $item['genre'] = $item->genre;
        });
        return response()->json($books);
    }

    public function getdeleted()
    {
        $temp = array();
        $books = Book::onlyTrashed()->get();
        foreach ($books as $item){
            $item['shelf'] = $item->shelf;
            $item['author'] = $item->author;
            $item['genre'] = $item->genre;
            $author = DB::table('authors')->where('id',$item->author->id)->where('deleted_at',NULL)->exists();
            $shelf = DB::table('shelves')->where('id',$item->shelf->id)->where('deleted_at',NULL)->exists();
            $genre = DB::table('genres')->where('id',$item->genre->id)->where('deleted_at',NULL)->exists();
            if($author && $shelf && $genre){

                array_push($temp,$item);
            }
        }

        return response()->json($temp);
    }

    public function last()
    {

        $book = DB::table('books')->orderBy('id','desc')->first();
        $book = Book::find($book->id);
        $book['shelf'] = $book->shelf;
        $book['authors'] = $book->author;
        return response()->json($book);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|unique:books',
            'author_id' => 'bail|required',
            'genre_id' => 'bail|required',
            'shelf_id' => 'bail|required',
            'stock' =>  'bail|required',
        ]);
        if ($validator->fails()){
            return response("ERROR: BOOK STORE", 500);
        }else{
            $book = Book::create($request->all());
            $book = Book::find($book->id);
            $book['shelf'] = $book->shelf;
            $book['author'] = $book->author;
            $book['genre'] = $book->genre;
            return response($book, 200);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        $book['shelf'] = $book->shelf;
        $book['author'] = $book->author;
        $book['genre'] = $book->genre;
        return response()->json($book);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Book::where('id',$id)->update($request->except(['shelf','genre','author']));
        $book = Book::find($id);
        $book['shelf'] = $book->shelf;
        $book['author'] = $book->author;
        $book['genre'] = $book->genre;
        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::destroy($id);
    }

    public function restore(Request $request)
    {
        Book::onlyTrashed()->find($request->id)->restore();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function borrow(Request $request)
    {
        if(Book::where('id',$request->book_id)->value('stock') > 0){
            $stock = Book::where('id',$request->book_id)->value('stock') - 1;
            BookUser::create($request->all());
            Book::where('id',$request->book_id)->update(['stock' => $stock]);
            $book = Book::find($request->book_id);
            $book['shelf'] = $book->shelf;
            $book['author'] = $book->author;
            $book['genre'] = $book->genre;
            return response()->json($book);
        }else{
            return response('Book stock mismatch please refresh the page',500);
        }

    }

    public function return(Request $request)
    {
        $stock = Book::where('id',$request->book_id)->value('stock') + 1;
        BookUser::where('book_id',$request->book_id)->where('user_id',$request->user_id)->delete();
        Book::where('id',$request->book_id)->update(['stock' => $stock]);
        $book = Book::find($request->book_id);
        $book['shelf'] = $book->shelf;
        $book['author'] = $book->author;
        $book['genre'] = $book->genre;
        return response()->json($book);
    }

    public function borrowedBooks($id)
    {
        $books = User::find($id);
        $books = $books->book;
        $books->each( function ($item, $key){
            $item['shelf'] = $item->shelf;
            $item['author'] = $item->author;
            $item['genre'] = $item->genre;
        });
        return response()->json($books);
    }
}
