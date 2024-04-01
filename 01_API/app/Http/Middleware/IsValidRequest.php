<?php

namespace App\Http\Middleware;

use AnsResponse;
use Closure;
use Illuminate\Support\Str;
use ResponseCode;

class IsValidRequest
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request All value from client
     * @param \Closure $next The action will be execute
     * @param string $type Type of request (for api or normal)
     * @return mixed The action will be execute after check
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $api_keys = explode(',', config('app.api_key'));
        $api_key = request()->header('x-api-key');
        $request_id = request()->header('x-request-id');
        if (!in_array($api_key, $api_keys) || !Str::isUuid($request_id)) {
            $response = new AnsResponse;
            $response->code = ResponseCode::BAD_REQUEST;
            $response->messageNo = 'E400';

            return response()->json($response, ResponseCode::BAD_REQUEST);
        }

        return $next($request);
    }
}
