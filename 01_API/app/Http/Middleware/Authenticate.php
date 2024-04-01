<?php

namespace App\Http\Middleware;

use AnsResponse;
use Closure;
use DbService;
use IdentityService;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use JWTAuth;
use ResponseCode;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        $isApi = isset($guards[0]) && $guards[0] == 'api';
        $isAjax = $request->ajax() || $request->wantsJson();
        $token = '';
        $logined = true;
        $functions = [];
        try {
            if ($isApi) {
                $token = JWTAuth::getToken();
            } else {
                $token = IdentityService::getCookie('token', '');
            }
            $apy = JWTAuth::setToken($token)->getPayload()->toArray();
            if ($isApi) {
                $payload = (array) json_decode($apy['logindata'] ?? '');
                $result = DbService::execSQL('SPC_0000_INQ2', [
                    'user_cd' => $payload['user_cd'] ?? '',
                ]);
                if (($result[0][0]['user_cd'] ?? '') === '') {
                    $logined = false;
                } else {
                    $functions = $result[1];
                }
            }
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException $e) {
            $logined = false;
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException $e) {
            $logined = false;
        } catch (\PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException $e) {
            $logined = false;
        }
        $have_permission = true;
        if ($logined) {
            $have_permission = IdentityService::havePermission($functions, $request->route()->getAction()['controller'] ?? '');
        }
        if ($isApi || $isAjax) {
            $response = new AnsResponse;
            if (!$logined) {
                $response->code = ResponseCode::UNAUTHORIZED;
                $response->messageNo = 'E401';

                return response()->json($response, ResponseCode::UNAUTHORIZED);
            }
            if (!$have_permission) {
                $response->code = ResponseCode::FORBIDDEN;
                $response->messageNo = 'E403';

                return response()->json($response->toArray(), ResponseCode::FORBIDDEN);
            }
        } else {
            if (!$logined) {
                $request->session()->put('urlBefore', $request->getRequestUri());

                return redirect()->route('login.index');
            }
            if (!$have_permission) {
                return redirect()->route('Error403');
            }
        }

        return $next($request);
    }
}
