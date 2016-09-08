<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;


class Place extends Model
{
    use PostgisTrait;

    protected $fillable = [
        'location',
        'phone_num',
        'detail',
    ];

    protected $postgisFields = [
        Point::class,
        Polygon::class,
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'place_tags', 'place_id', 'tag_id');
    }

}
