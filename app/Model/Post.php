<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'user_id', 'description', 'status', 'type'
    ];

    public function postImage()
    {
        return $this->hasMany('App\Model\PostImage');
    }
}
