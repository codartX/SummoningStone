<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'user_tags', 'user_id', 'tag_id');
    }

    public function activities()
    {
        return $this->belongsToMany('App\Activity', 'user_activities', 'user_id', 'activity_id');
    }

    public function followers()
    {
        return $this->hasMany('App\Follower');
    }
}
