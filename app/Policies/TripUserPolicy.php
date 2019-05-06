<?php

namespace App\Policies;

use App\Model\User;
use App\Model\TripUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function view(User $user, TripUser $tripUser)
    {
        //
    }

    /**
     * Determine whether the user can create trip users.
     *
     * @param  \App\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function update(User $user, TripUser $tripUser)
    {
        //
    }

    /**
     * Determine whether the user can delete the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function delete(User $user, TripUser $tripUser)
    {
        //
    }

    /**
     * Determine whether the user can restore the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function restore(User $user, TripUser $tripUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function forceDelete(User $user, TripUser $tripUser)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function declinedInvitation(User $user, TripUser $tripUser) {
        return $user->id === $tripUser->user_id || $user->id === $tripUser->trip->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function acceptInvitation(User $user, TripUser $tripUser) {
        return $user->id === $tripUser->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function rejectJoinRequest(User $user, TripUser $tripUser) {
        return $user->id === $tripUser->user_id || $user->id === $tripUser->trip->user_id;
    }

    /**
     * Determine whether the user can permanently delete the trip user.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\TripUser  $tripUser
     * @return mixed
     */
    public function acceptJoinRequest(User $user, TripUser $tripUser) {
        return $user->id === $tripUser->trip->user_id;
    }
}
