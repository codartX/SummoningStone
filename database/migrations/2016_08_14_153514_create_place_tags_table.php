<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlaceTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_tags', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('place_id');
            $table->foreign('place_id')
                  ->references('id')->on('places')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('tag_id');
            $table->foreign('tag_id')
                  ->references('id')->on('tags')
                  ->onDelete('cascade')->onUpdate('cascade');

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
        Schema::drop('place_tags');
    }
}
