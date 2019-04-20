<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    //
    protected $fillable = ['trip_id', 'user_id', 'accepted'];
}
