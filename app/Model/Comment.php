<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = [
        'user_id', 'post_id', 'content', 'comment_id'
    ];


    public function user() {
        return $this->belongsTo('App\Model\User')->withDefault();
    }
}
