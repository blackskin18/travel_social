<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    //
    protected $fillable = [
        'user_id', 'trip_id', 'post_id'
    ];
}
