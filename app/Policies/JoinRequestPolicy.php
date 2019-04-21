<?php

namespace App\Policies;

use App\Model\User;
use App\Model\JoinRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class JoinRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the join request.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\JoinRequest  $joinRequest
     * @return mixed
     */
    public function view(User $user, JoinRequest $joinRequest)
    {
        //
    }

    /**
     * Determine whether the user can create join requests.
     *
     * @param  \App\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the join request.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\JoinRequest  $joinRequest
     * @return mixed
     */
    public function update(User $user, JoinRequest $joinRequest)
    {
        //user who created the trip can delete this request (accept)
        return $user->id === $joinRequest->trip->user_id;
    }

    /**
     * Determine whether the user can delete the join request.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\JoinRequest  $joinRequest
     * @return mixed
     */
    public function delete(User $user, JoinRequest $joinRequest)
    {
        // user send join request OR user who created the trip can delete this request
        $user->id === $joinRequest->user_id || $user->id === $joinRequest->trip->user_id;
    }

    /**
     * Determine whether the user can restore the join request.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\JoinRequest  $joinRequest
     * @return mixed
     */
    public function restore(User $user, JoinRequest $joinRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the join request.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\JoinRequest  $joinRequest
     * @return mixed
     */
    public function forceDelete(User $user, JoinRequest $joinRequest)
    {
        //
    }
}
