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
        'title', 'user_id', 'accepted'
    ];

    public function userJoin() {
        return $this->belongsToMany('App\Model\User', 'trip_users');
    }

    public function user() {
        return $this->belongsTo('App\Model\User');
    }

    public function position() {
        return $this->hasMany('App\Model\Position');
    }

}
