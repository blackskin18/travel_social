<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Friend;
use Illuminate\Auth\Access\HandlesAuthorization;

class FriendPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the friend.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Friend  $friend
     * @return mixed
     */
    public function view(User $user, Friend $friend)
    {
        //
    }

    /**
     * Determine whether the user can create friends.
     *
     * @param  \App\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the friend.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Friend  $friend
     * @return mixed
     */
    public function update(User $user, Friend $friend)
    {
        //
    }

    /**
     * Determine whether the user can delete the friend.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Friend  $friend
     * @return mixed
     */
    public function cancel(User $user, Friend $friend)
    {
        //
        return $user->id === $friend->user_one_id || $user->id === $friend->user_two_id;
    }

    /**
     * Determine whether the user can restore the friend.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Friend  $friend
     * @return mixed
     */
    public function restore(User $user, Friend $friend)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the friend.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Friend  $friend
     * @return mixed
     */
    public function forceDelete(User $user, Friend $friend)
    {
        //
    }
}
