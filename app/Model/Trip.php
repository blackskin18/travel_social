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
        'post_id', 'title', 'user_id', 'accepted'
    ];

    protected $visible = ['id'];

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
}
