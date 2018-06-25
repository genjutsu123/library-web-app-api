<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $genres = array('Horror','Action','Drama','Adventure','Romance','Tragedy','Fiction','Art');
        $shelves = array('Kids','Teens','Fiction','Adult','Elderly');
        foreach ($genres as $genre){
            DB::table('genres')->insert([
                'name' => $genre,
            ]);
        }
        foreach ($shelves as $shelf){
            DB::table('shelves')->insert([
               'name' => $shelf,
            ]);
        }
        factory(App\Author::class,10)->create()->each(function ($x){
            $x->save();
        });

        factory(App\Book::class,10)->create()->each(function($x){
            $x->save();
        });
        $authors = App\Author::all();
        $books = App\Book::all();
        $genres = App\Genre::all();
        $shelves = App\Shelf::all();

        foreach ($books as $book){

            App\Book::where('id',$book->id)->update(['genre_id' => $genres->random()->id, 'shelf_id' => $shelves->random()->id, 'author_id' => $authors->random()->id]);

//            DB::table('book_genre')->insert([
//                'book_id' => $book->id,
//                'genre_id' => $genres->random()->id
//            ]);
//            DB::table('book_shelf')->insert([
//                'book_id' => $book->id,
//                'shelf_id' => $shelves->random()->id
//            ]);
//            DB::table('author_book')->insert([
//                'book_id' => $book->id,
//                'author_id' => $authors->random()->id
//            ]);
        }
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Librarian',
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Pleb',
        ]);

        DB::table('users')->insert([
            'role_id' => 1,
            'name' => 'Admin',
            'email' => ('admin@admin.com'),
            'password' => bcrypt('admin'),
        ]);

        DB::table('users')->insert([
            'role_id' => 2,
            'name' => 'Pleb Mcgee',
            'email' => ('pleb@pleb.com'),
            'password' => bcrypt('pleb'),
        ]);

//        DB::table('role_user')->insert([
//            'user_id' => 1,
//            'role_id' => 1,
//        ]);
//
//        DB::table('role_user')->insert([
//            'user_id' => 2,
//            'role_id' => 2,
//        ]);

    }
}
