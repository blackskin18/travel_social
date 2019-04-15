<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Trip;
use Illuminate\Auth\Access\HandlesAuthorization;

class TripPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model trip.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Trip  $trip
     * @return mixed
     */
    public function view(User $user, Trip $trip)
    {
        //
    }

    /**
     * Determine whether the user can create model trips.
     *
     * @param  \App\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model trip.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Trip  $trip
     * @return mixed
     */
    public function update(User $user, Trip $trip)
    {
        //
        return $user->id === $trip->user_id;
    }

    /**
     * Determine whether the user can delete the model trip.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Trip  $trip
     * @return mixed
     */
    public function delete(User $user, Trip $trip)
    {
        //
        return $user->id === $trip->user_id;
    }

    /**
     * Determine whether the user can restore the model trip.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Trip  $trip
     * @return mixed
     */
    public function restore(User $user, Trip $trip)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model trip.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Trip  $trip
     * @return mixed
     */
    public function forceDelete(User $user, Trip $trip)
    {
        //
    }
}
