<?php

use Illuminate\Database\Seeder;

class OAuthClientTableSeeder extends Seeder 
{

    public function run()
    {

        DB::table('oauth_clients')->delete();

        DB::table('oauth_clients')->insert([
            'id'     => 'admin',
            'secret' => 'cisco123',
            'name'   => 'admin'
        ]);
    }

}
