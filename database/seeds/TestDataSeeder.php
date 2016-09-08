<?php

use Illuminate\Database\Seeder;
use Phaza\LaravelPostgis\Geometries\Point;
use App\Activity;
use App\Comment;
use App\Follower;
use App\Share;
use App\Tag;
use App\ThumbUp;
use App\User;

class TestDataSeeder extends Seeder
{
    public function run()
    {
        DB::table('comments')->delete();
        DB::table('activities')->delete();
        DB::table('followers')->delete();
        DB::table('shares')->delete();
        DB::table('thumb_ups')->delete();

    }
}
