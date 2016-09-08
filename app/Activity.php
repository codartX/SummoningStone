<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;

class Activity extends Model
{
    use PostgisTrait;

    protected $fillable = [
        'title',
        'detail',
        'headcount',
        'member_count',
        'recruit_deadline',
        'start_time',
        'end_time',
        'location',
    ];

    protected $postgisFields = [
        Point::class,
        Polygon::class,
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'activity_tags', 'activity_id', 'tag_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function shares()
    {
        return $this->hasMany('App\Share');
    }

    public function thumb_ups()
    {
        return $this->hasMany('App\ThumbUp');
    }
}
