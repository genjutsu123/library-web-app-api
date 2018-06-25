<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookShelvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('book_shelf', function (Blueprint $table) {
//            $table->unsignedInteger('book_id');
//            $table->foreign('book_id')->
//                references('id')->
//                on('books')->
//                onDelete('cascade');
//            $table->unsignedInteger('shelf_id');
//            $table->foreign('shelf_id')->
//                references('id')->
//                on('shelves')->
//                onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_shelves');
    }
}
