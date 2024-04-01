<?php
/**
 * LoginController
 * Processing for screen Login
 *
 * 処理概要/process overview  : LoginController
 * 作成日/create date         : 2024/02/17
 * 作成者/creater             : QuyPN - quypn@ans-asia.com
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @copyright Copyright (c) ANS-ASIA
 *
 * @version 1.0.0
 */

namespace App\api\System\Controllers;

use App\api\System\Actions\Login\CheckAccountAction;
use App\api\System\Requests\Login\LoginRequest;
use App\api\System\Resources\Login\LoginResource;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Check information of user login correct or not.
     * Created: 2024/02/17
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return LoginResource Result of login, have token if login success
     */
    public function login(LoginRequest $request, CheckAccountAction $action): LoginResource
    {
        return new LoginResource($action->handle($request->makeAccount()));
    }
}
