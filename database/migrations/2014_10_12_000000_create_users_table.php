<?php

use Phaza\LaravelPostgis\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('client_id')
                  ->nullable();

            $table->foreign('client_id')
                  ->references('id')->on('oauth_clients')
                  ->onDelete('set null');

            $table->integer('score');

            $table->float('lat')->nullable();
            $table->float('lng')->nullable();
            $table->point('location')->nullable();

            $table->string('weixin_id')->nullable();

            $table->rememberToken();
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
        Schema::drop('users');
    }
}
