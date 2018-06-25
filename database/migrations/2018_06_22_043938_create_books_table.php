<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('stock')->nullable();
            $table->unsignedInteger('author_id')->nullable();
            $table->foreign('author_id')->
                references('id')->
                on('authors')->
                onDelete('cascade');
            $table->unsignedInteger('genre_id')->nullable();
            $table->foreign('genre_id')->
                references('id')->
                on('genres')->
                onDelete('cascade');
            $table->unsignedInteger('shelf_id')->nullable();
            $table->foreign('shelf_id')->
                references('id')->
                on('shelves')->
                onDelete('cascade');
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
