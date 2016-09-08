<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_tags', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('activity_id');
            $table->foreign('activity_id')
                  ->references('id')->on('activities')
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
        Schema::drop('activity_tags');
    }
}
