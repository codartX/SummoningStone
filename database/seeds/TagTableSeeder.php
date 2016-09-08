<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagTableSeeder extends Seeder 
{

    public function run()
    {
        DB::table('tags')->delete();

        Tag::create(array(
            'name' => 'Football',
        ));

        Tag::create(array(
            'name' => 'Basketball',
        ));

        Tag::create(array(
            'name' => 'Tennis',
        ));

        Tag::create(array(
            'name' => 'Party',
        ));

    }

}
