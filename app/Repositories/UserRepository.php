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

        $friendIds = $this->friendRepo->getAllFriendIdOfUser($authUserId);
        $friendInSearchResult = $users->intersect(User::whereIn('id', $friendIds)->get());

        $users = $users->except($friendIds);
        return [
            'users' => $users,
            'friends' => $friendInSearchResult,
        ];
    }
}
