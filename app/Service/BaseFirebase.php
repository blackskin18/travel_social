<?php

namespace App\Service;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;
//use LRedis;

class BaseFirebase
{
    protected $firebase;

    public function __construct()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'\my-project-1500357993095-firebase-adminsdk-5hx9g-64e2fc912c.json');
        $firebase 		  = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://my-project-1500357993095.firebaseio.com')
            ->create();
        $this->firebase = $firebase;
    }

    public function getFirebaseToken($tripId) {
//        dd($this->firebase->getAuth()->createCustomToken($tripId));
        return (string) $this->firebase->getAuth()->createCustomToken($tripId);
    }

}
