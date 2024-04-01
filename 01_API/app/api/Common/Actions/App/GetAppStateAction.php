<?php

namespace App\api\Common\Actions\App;

use App\api\Common\Models\App\AppState;
use App\api\Common\Models\App\Profile;
use App\Repositories\IAppSateRepository;

class GetAppStateAction
{
    private IAppSateRepository $appSateRepository;

    public function __construct(IAppSateRepository $appSateRepository)
    {
        $this->appSateRepository = $appSateRepository;
    }

    public function handle(): AppState
    {
        $response = new AppState;
        try {
            $result = $this->appSateRepository->getAppState();
            $response->profile = new Profile($result[0][0] ?? []);
            $response->setMenus($result[1] ?? []);
            $response->setFunctions($result[2] ?? []);
            $response->setMessages($result[3] ?? []);
        } catch (\Exception $e) {
        }

        return $response;
    }
}
