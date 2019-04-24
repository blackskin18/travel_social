<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TripUser extends Model
{
    protected $fillable = [
        'user_id', 'trip_id'
    ];

    public function trip() {
        return $this->belongsTo('App\Model\Trip');
    }
}
