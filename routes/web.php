<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::resource('authors','AuthorController');
Route::post('authorrestore','AuthorController@restore');
Route::get('authorsdeleted','AuthorController@getdeleted');

Route::resource('genres','GenreController');
Route::post('genrerestore','GenreController@restore');
Route::get('genresdeleted','GenreController@getdeleted');

Route::resource('books','BookController');
Route::get('booklibrarian','BookController@librarian');
Route::get('booksdeleted','BookController@getdeleted');
Route::post('bookrestore','BookController@restore');
Route::get('bookborrow/{id}','BookController@borrowedBooks');
Route::post('bookborrow','BookController@borrow');
Route::post('bookreturn','BookController@return');

Route::resource('shelves','ShelfController');
Route::post('shelverestore','ShelfController@restore');
Route::get('shelvesdeleted','ShelfController@getdeleted');

Route::resource('authorbooks','AuthorBookController');

Route::resource('bookshelves','BookShelveController');

Route::resource('bookgenres','BookGenreController');

Route::resource('users','UserController');
Route::post('login','UserController@login');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
