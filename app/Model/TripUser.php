<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class TripUser extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['trip_id', 'user_id'];
}
