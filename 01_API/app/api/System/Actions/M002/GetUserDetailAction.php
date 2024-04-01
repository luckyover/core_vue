<?php

namespace App\api\System\Actions\M002;

use App\api\System\Models\M002\User;
use App\Repositories\IUserRepository;

class GetUserDetailAction
{
    private IUserRepository $userRepository;

    public function __construct(
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(?string $id): User
    {
        return new User($this->userRepository->find($id));
    }
}
