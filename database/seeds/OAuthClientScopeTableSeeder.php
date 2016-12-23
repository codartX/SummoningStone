<?php

use Illuminate\Database\Seeder;

class OAuthClientScopeTableSeeder extends Seeder 
{

    public function run()
    {

        DB::table('oauth_client_scopes')->delete();

        DB::table('oauth_client_scopes')->insert([
            'client_id'     => 'admin',
            'scope_id'      => 'activity_control',
        ]);

        DB::table('oauth_client_scopes')->insert([
            'client_id'     => 'admin',
            'scope_id'      => 'user_control',
        ]);

        DB::table('oauth_client_scopes')->insert([
            'client_id'     => 'admin',
            'scope_id'      => 'tag_control',
        ]);

        DB::table('oauth_client_scopes')->insert([
            'client_id'     => 'admin',
            'scope_id'      => 'comment_control',
        ]);
    }

}
