<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(OAuthClientTableSeeder::class);
        $this->call(OAuthScopeTableSeeder::class);
        $this->call(OAuthClientScopeTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(TagTableSeeder::class);
        //$this->call(TestDataSeeder::class);
    }
}
