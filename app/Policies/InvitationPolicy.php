<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Invitation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the invitation.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Invitation  $invitation
     * @return mixed
     */
    public function view(User $user, Invitation $invitation)
    {
        //
    }

    /**
     * Determine whether the user can create invitations.
     *
     * @param  \App\Model\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the invitation.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Invitation  $invitation
     * @return mixed
     */
    public function update(User $user, Invitation $invitation)
    {
        //
        return $user->id === $invitation->user_id;
    }

    /**
     * Determine whether the user can delete the invitation.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Invitation  $invitation
     * @return mixed
     */
    public function delete(User $user, Invitation $invitation)
    {
        //
        return $user->id === $invitation->user_id || $user->id === $invitation->trip->user_id;
    }

    /**
     * Determine whether the user can restore the invitation.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Invitation  $invitation
     * @return mixed
     */
    public function restore(User $user, Invitation $invitation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the invitation.
     *
     * @param  \App\Model\User  $user
     * @param  \App\Model\Invitation  $invitation
     * @return mixed
     */
    public function forceDelete(User $user, Invitation $invitation)
    {
        //
    }
}
