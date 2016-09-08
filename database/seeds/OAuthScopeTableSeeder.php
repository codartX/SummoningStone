<?php

use Illuminate\Database\Seeder;

class OAuthScopeTableSeeder extends Seeder 
{

    public function run()
    {

        DB::table('oauth_scopes')->delete();

        DB::table('oauth_scopes')->insert([
            'id'          => 'activity_control',
            'description' => 'Get, Add, Update and Delete Activity Scope'
        ]);

        DB::table('oauth_scopes')->insert([
            'id'          => 'user_control',
            'description' => 'Get, Add, Update and Delete User Scope'
        ]);

        DB::table('oauth_scopes')->insert([
            'id'          => 'tag_control',
            'description' => 'Get, Add, Update and Delete Tag Scope'
        ]);

    }

}
