<?php

use Phaza\LaravelPostgis\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('detail')->nullable;
            $table->integer('headcount');
            $table->integer('member_count');
            $table->timestamp('recruit_deadline');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->point('location')->nullable();
            $table->string('weixin_group_id')->nullable();

            $table->integer('owner_id');
            $table->foreign('owner_id')
                  ->references('id')->on('users')
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
        Schema::drop('activities');
    }
}
