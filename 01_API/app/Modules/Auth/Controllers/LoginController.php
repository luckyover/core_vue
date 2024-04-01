<?php
/**
 * LoginController
 * Process for login and logout of development can view api doc
 *
 * 処理概要/process overview  : LoginController
 * 作成日/create date         : 2022/03/31
 * 作成者/creater             : quypn@ans-asia.com
 *
 * 更新日/update date         :
 * 更新者/updater             :
 * 更新内容 /update content   :
 *
 * @copyright Copyright (c) ANS-ASIA
 *
 * @version 1.0.0
 */

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Actions\Login\CheckAccountAction;
use App\Modules\Auth\Requests\Login\LoginRequest;
use App\Modules\Auth\Resources\Login\LoginResource;
use IdentityService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Show page login.
     * Created: 2022/03/31
     *
     * @author QuyPN <quypn@ans-asia.com>
     *
     * @return View|Factory Page login or error page if have exception. If has login, then return home page
     */
    public function index(Request $request): View|Factory|RedirectResponse
    {
        $token = IdentityService::getCookie('token');
        if ($token !== '') {
            return redirect()->route('home');
        }

        return view('Auth::Login.index');
    }

    public function store(LoginRequest $request, CheckAccountAction $actions): LoginResource
    {
        return new LoginResource($actions->handle($request->makeAccount()));
    }
}
