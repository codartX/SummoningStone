<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder 
{

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
            'name' => 'admin',
            'email' => 'apifan@gmail.com',
            'password' => Hash::make('cisco123'),
            'client_id' => 'admin',
            'score' => 4.0,
        ));
    }

}
