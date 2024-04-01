<?php

namespace App\Http\Middleware;

use Closure;
use IdentityService;
use Illuminate\Support\Facades\View;

class AppState
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $appState = [
            'user' => IdentityService::getCurrentUser(),
        ];
        $request->session()->put('state', $appState);
        View::share('state', $appState);

        return $next($request);
    }
}
