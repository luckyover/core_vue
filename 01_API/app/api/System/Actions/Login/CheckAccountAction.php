<?php

namespace App\api\System\Actions\Login;

use App\api\System\Models\Login\Account;
use App\api\System\Models\Login\Token;
use App\Repositories\IUserRepository;
use IdentityService;

class CheckAccountAction
{
    private IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Account $account): Token
    {
        $result = $this->userRepository->checkUserLogin($account);
        $response = new Token($result[1][0] ?? []);
        $response->token = IdentityService::getToken($account->username, []);
        $response->timeout = config('jwt.ttl');
        $response->urlBefore = session()->get('urlBefore');

        return $response;
    }
}
