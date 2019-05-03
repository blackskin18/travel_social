<?php

namespace App\Providers;

use App\Model\Friend;
use App\Model\JoinRequest;
use App\Model\TripUser;
use App\Policies\FriendPolicy;
use App\Policies\JoinRequestPolicy;
use App\Policies\TripUserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Model\Post;
use App\Model\Trip;
use App\Model\Invitation;
use App\Policies\PostPolicy;
use App\Policies\InvitationPolicy;
use App\Policies\TripPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Post::class => PostPolicy::class,
        Trip::class => TripPolicy::class,
        TripUser::class=>TripUserPolicy::class,
        //Invitation::class => InvitationPolicy::class,
        //JoinRequest::class => JoinRequestPolicy::class,
        Friend::class => FriendPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
