<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class Comment extends Model
{

    use SyncsWithFirebase;
    //
    protected $fillable = [
        'user_id', 'post_id', 'content', 'comment_id'
    ];

    protected $visible = ['post_id', 'user_id', 'content'];


    public function user() {
        return $this->belongsTo('App\Model\User')->withDefault();
    }
}
