<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [
        'user_id', 'description', 'status', 'type'
    ];

    public function post_image()
    {
        return $this->hasMany('App\Model\PostImage');
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User');
    }

    public function position()
    {
        return $this->hasMany('App\Model\Position');
    }

    public function like()
    {
        return $this->hasMany('App\Model\Like');
    }
}
