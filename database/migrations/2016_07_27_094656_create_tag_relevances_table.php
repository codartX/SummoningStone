<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagRelevancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_relevances', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('tag_id');
            $table->foreign('tag_id')
                  ->references('id')->on('tags')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->integer('relevant_tag_id');
            $table->foreign('relevant_tag_id')
                  ->references('id')->on('tags')
                  ->onDelete('cascade')->onUpdate('cascade');

            $table->float('relevance');

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
        Schema::drop('tag_relevances');
    }
}
