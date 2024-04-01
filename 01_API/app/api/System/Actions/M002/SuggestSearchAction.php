<?php

namespace App\api\System\Actions\M002;

use App\Repositories\IUserRepository;

class SuggestSearchAction
{
    private IUserRepository $userRepository;

    public function __construct(
        IUserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    public function handle(?string $search): array
    {
        return $this->userRepository->suggestSearch($search);
    }
}
