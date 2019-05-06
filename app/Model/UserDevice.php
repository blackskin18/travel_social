<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Mpociot\Firebase\SyncsWithFirebase;

class UserDevice extends Model
{

    use SyncsWithFirebase;
    //
    protected $fillable = [
        'user_id', 'device_token'
    ];

    public function user() {
        return $this->belongsTo('App\Model\User');
    }
}
