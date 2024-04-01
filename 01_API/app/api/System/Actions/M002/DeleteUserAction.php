<?php

namespace App\api\System\Actions\M002;

use App\Repositories\IUserRepository;

class DeleteUserAction
{
    private IUserRepository $userRepository;

    public function __construct(
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(?string $user_cd)
    {
        $this->userRepository->delete($user_cd);
    }
}
