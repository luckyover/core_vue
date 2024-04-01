<?php

namespace App\Modules\Auth\Actions\Login;

use App\Modules\Auth\Models\Login\Account;
use App\Modules\Auth\Models\Login\Token;
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
        $result = $this->userRepository->checkUserSwaggerLogin($account);
        $response = new Token($result[0][0] ?? []);
        $response->token = IdentityService::getToken($account->username, []);
        $response->timeout = config('jwt.ttl');
        $response->urlBefore = session()->get('urlBefore');

        return $response;
    }
}
