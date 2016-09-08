<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThumbUp extends Model
{
    protected $fillable = [
        'user_id',
        'activity_id',
    ];

}
