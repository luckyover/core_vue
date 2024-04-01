<?php

namespace App\api\System\Actions\M002;

use App\api\System\Models\M002\UserDetail;
use App\Repositories\IUserRepository;

class SaveUserAction
{
    private IUserRepository $userRepository;

    public function __construct(
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(UserDetail $user)
    {
        $this->userRepository->save($user);
    }
}
