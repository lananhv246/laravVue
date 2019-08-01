<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            // $table->collation = 'utf8_general_ci';
            $table->integer('authorId')->unsigned();
            $table->foreign('authorId') ->references('id') ->on('users')->onDelete('cascade') ;
            $table->string('title');
            $table->text('content', 1000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
