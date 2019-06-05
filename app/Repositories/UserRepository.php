<?php

namespace App\Repository;

use App\Model\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    private $friendRepo;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "App\\Model\\User";
    }

    public function __construct(
        \Illuminate\Container\Container $app,
        FriendRepository $friendRepo
    ) {
        $this->friendRepo = $friendRepo;
        parent::__construct($app);
    }

    public function searchUser($searchText, $authUserId)
    {
        $users = User::where('name', 'like', '%'.$searchText.'%')->orWhere('email', 'like', '%'.$searchText.'%')->orWhere('description', 'like', '%'.$searchText.'%')->orWhere('phone', '=', $searchText)->get();
        $users = $users->except([$authUserId]);

        $friendshipIds = $this->friendRepo->getAllFriendIdOfUser($authUserId);
        $friendInSearchResult = $users->intersect(User::whereIn('id', $friendshipIds['friend'])->get());

        $userSentInSearchResult = $users->intersect(User::whereIn('id', $friendshipIds['user_sent_request'])->get());
        $userReceiveSearchResult = $users->intersect(User::whereIn('id', $friendshipIds['user_receive_request'])->get());

        $users = $users->except($friendshipIds['friend']);
        $users = $users->except($friendshipIds['user_sent_request']);
        $users = $users->except($friendshipIds['user_receive_request']);

        return [
            'users' => $users,
            'friends' => $friendInSearchResult,
            'user_sent_request' => $userSentInSearchResult,
            'user_receive_request' => $userReceiveSearchResult,
        ];
    }

    /**
     *
     * $userId: get list friend of this user
     * $authUserId: id of user who is login
     *
     */
    public function getAllFriendOfUser($userId, $authUserId)
    {
        //user's friends
        $friendShipsOfUser = $this->friendRepo->getAllFriendShipOfUser($userId);
        //auth user's friends
        $allFriendshipIdsOfAuthUser = $this->friendRepo->getAllFriendIdOfUser($authUserId);
        // friends of auth user and user
        $friendsOfAuthUser = [];
        // list user who is friend of USER and was received request by auth user
        $userReceivedRequestByAuthUser = [];
        // list user who is friend of USER and sent request to auth user
        $userSentRequestToAuthUser = [];

        $friendKeyToRemove = [];

        foreach ($friendShipsOfUser as $key => $friendShipOfUser) {
            $flag = false;
            if (! $flag) {
                foreach ($allFriendshipIdsOfAuthUser['friend'] as $friend) {
                    if (($friendShipOfUser->user_one_id === $friend && $friend != $userId) ||
                        ($friendShipOfUser->user_two_id === $friend && $friend != $userId)) {
                        array_push($friendsOfAuthUser, $friendShipOfUser);
                        array_push($friendKeyToRemove, $key);
                        $flag = true;
                        break;
                    }
                }
            }
            if (! $flag) {
                foreach ($allFriendshipIdsOfAuthUser['user_sent_request'] as $userSentRequest) {
                    if (($friendShipOfUser->user_one_id === $userSentRequest && $userSentRequest != $userId) ||
                        ($friendShipOfUser->user_two_id === $userSentRequest && $userSentRequest != $userId)) {
                        array_push($userSentRequestToAuthUser, $friendShipOfUser);
                        array_push($friendKeyToRemove, $key);
                        $flag = true;
                        break;
                    }
                }
            }
            if (! $flag) {
                foreach ($allFriendshipIdsOfAuthUser['user_receive_request'] as $userReceiveRequest) {
                    if (($friendShipOfUser->user_one_id === $userReceiveRequest && $userReceiveRequest != $userId) ||
                        ($friendShipOfUser->user_two_id === $userReceiveRequest && $userReceiveRequest != $userId)) {
                        array_push($userReceivedRequestByAuthUser, $friendShipOfUser);
                        array_push($friendKeyToRemove, $key);
                        $flag = true;
                        break;
                    }
                }
            }
        }

        foreach ($friendKeyToRemove as $key) {
            unset($friendShipsOfUser[$key]);
        }

        return [
            "users" => $friendShipsOfUser,
            "friends" => $friendsOfAuthUser,
            "users_sent_request" => $userSentRequestToAuthUser,
            "users_receive_request" => $userReceivedRequestByAuthUser,
        ];
    }
}
