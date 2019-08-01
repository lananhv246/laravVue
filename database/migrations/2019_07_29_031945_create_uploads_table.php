<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userId')->unsigned();
            $table->foreign('userId') ->references('id') ->on('users')->onDelete('cascade') ;
            $table->string('path');
            $table->string('fileName');
            $table->string('type');
            $table->integer('size');
            $table->string('section');
            $table->integer('itemId');
            $table->string('itemToken');
            // $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            // $table->collation = 'utf8_general_ci';
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
        Schema::dropIfExists('uploads');
    }
}
