<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    //
    protected $fillable = [
        'user_one_id', 'user_two_id', 'type'
    ];
}
