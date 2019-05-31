<?php
namespace App\Repository;

use App\Model\User;
use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository {

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

    public function searchUser($searchText, $authUserId) {
        $users = User::where('name', 'like', '%'.$searchText.'%')
                ->orWhere('email', 'like', '%' . $searchText . '%')
                ->orWhere('description', 'like', '%' . $searchText . '%')
                ->orWhere('phone', '=', $searchText)
                ->get();
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

//    public function getAllFriendOfUser($userId, $authUserId) {
//        // bạn bè của người dùng
//        $friendShipsOfUser = $this->friendRepo->getAllFriendOfUser($userId);
//        // bạn bè của người đang đăng nhập
//        $friendshipIdsOfAuthUser = $this->friendRepo->getAllFriendIdOfUser($authUserId);
//
//        $users = [];
//        $friends = [];
//        $userSentRequest = [];
//        $userReceivedRequest = [];
//
//        $friendKeyToRemove = [];
//
//        foreach ($friendShipsOfUser as $key => $friendShipOfUser) {
//            $flag = false;
//            if(!$flag) {
//                foreach ($friendshipIdsOfAuthUser['friend'] as $friend) {
//                    if($friendShipOfUser->user_one_id === $friend->id || $friendShipOfUser->user_two_id === $friend->id) {
//                        array_push($friends, $friendShipOfUser);
//                        array_push($friendKeyToRemove, $key);
//                        $flag = true;
//                        break;
//                    }
//                }
//            }
//            if(!$flag) {
//                foreach ($friendshipIdsOfAuthUser['user_sent_request'] as $userSentRequest) {
//                    if ($friendShipOfUser->user_one_id === $friend->id || $friendShipOfUser->user_two_id === $friend->id) {
//                        array_push($userSentRequest, $friendShipOfUser);
//                        array_push($friendKeyToRemove, $key);
//                        $flag = true;
//                        break;
//                    }
//                }
//            }
//            if(!$flag) {
//                foreach ($friendshipIdsOfAuthUser['user_receive_request'] as $userReceiveRequest) {
//                    if ($friendShipOfUser->user_one_id === $userReceiveRequest->id || $friendShipOfUser->user_two_id === $userReceiveRequest->id) {
//                        array_push($userReceivedRequest, $friendShipOfUser);
//                        array_push($friendKeyToRemove, $key);
//                        $flag = true;
//                        break;
//                    }
//                }
//            }
//
//        }
//    }
}
