<?php

namespace App\Repositories\Implements;

use App\Repositories\IAppSateRepository;
use DbService;
use IdentityService;

class AppSateRepository implements IAppSateRepository
{
    public function __construct()
    {
    }

    public function getAppState()
    {
        $result = DbService::execSQL('SPC_0000_INQ1', [
            'user_cd' => IdentityService::getCurrentUserId(),
        ]);

        return $result ?? [];
    }
}
