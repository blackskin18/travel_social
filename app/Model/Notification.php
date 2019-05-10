<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //

    protected $fillable = [
        'user_send', 'user_receive', 'trip_id', 'post_id', 'type'
    ];

    public function userReceive()
    {
        return $this->belongsTo('App\Model\User', 'user_receive');
    }

    public function userSend() {
        return $this->belongsTo('App\Model\User', 'user_send');
    }

    public function trip() {
        return $this->belongsTo('App\Model\Trip');
    }

    public function post() {
        return $this->belongsTo('App\Model\Post');
    }
}
