<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'post_id', 'trip_id', 'lat', 'lng', 'description'
    ];
}
