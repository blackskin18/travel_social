<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Invitation extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['trip_id', 'user_id'];

    public function trip() {
        return $this->belongsTo('App\Model\Trip');
    }

    public function user() {
        return $this->belongsTo('App\Model\User');
    }
}
