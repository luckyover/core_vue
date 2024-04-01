<?php

namespace App\api\System\Actions\M002;

use App\api\System\Models\M002\ListOfUsers;
use App\api\System\Models\M002\SearchCondition;
use App\Models\AnsPaging;
use App\Repositories\IUserRepository;

class SearchUserAction
{
    private IUserRepository $userRepository;

    public function __construct(
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(SearchCondition $condition): ListOfUsers
    {
        $data = $this->userRepository->search($condition);
        $result = new ListOfUsers;
        $result->paging = new AnsPaging($data[1][0] ?? []);
        $result->setUsers($data[0] ?? []);

        return $result;
    }
}
