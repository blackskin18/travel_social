<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    //
    protected $fillable = [
        'user_one_id', 'user_two_id', 'type'
    ];

    public function userOne() {
        return $this->belongsTo('App\Model\User', 'user_one_id');
    }
    public function userTwo() {
        return $this->belongsTo('App\Model\User', 'user_two_id');
    }
}
