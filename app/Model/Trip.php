<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Trip extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'post_id', 'title', 'user_id', 'description', 'time_start', 'time_end'
    ];

    protected $visible = ['id', 'user_id', 'user', 'title'];

    public function userJoin() {
        return $this->belongsToMany('App\Model\User', 'trip_users');
    }

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function position() {
        return $this->hasMany('App\Model\Position');
    }

    public function post() {
        return $this->hasOne('App\Model\Post');
    }

    public function tripUser() {
        return $this->belongsToMany('App\Model\User', 'trip_users');
    }
}
