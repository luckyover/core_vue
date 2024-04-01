<?php

namespace App\Services;

use DbService;
use JWTAuth;
use JWTFactory;

class IdentityService
{
    public function __construct()
    {
    }

    /**
     * Get IP address of the request.
     */
    public static function getIPAddress(): string
    {
        return request()->ip();
    }

    /**
     * Get the value of a cookie by key.
     */
    public static function getCookie(string $key, string $default = ''): string
    {
        return $_COOKIE[$key] ?? $default;
    }

    /**
     * Get the ID of the currently logged-in user.
     */
    public static function getCurrentUserId(): string
    {
        try {
            $token = self::getCookie('token');
            if ($token === '') {
                $token = JWTAuth::getToken();
            }
            $apy = JWTAuth::setToken($token)->getPayload()->toArray();
            $payload = (array) json_decode($apy['logindata'] ?? '');

            return $payload['user_cd'] ?? '';
        } catch (\Exception $e) {
        }

        return '';
    }

    /**
     * Get information about the currently logged-in user.
     */
    public static function getCurrentUser(): array
    {
        try {
            $token = self::getCookie('token');
            if ($token === '') {
                $token = JWTAuth::getToken();
            }
            $apy = JWTAuth::setToken($token)->getPayload()->toArray();
            $payload = (array) json_decode($apy['logindata'] ?? '');
            $result = DbService::execSQL('SPC_M002_INQ2', [
                'user_cd' => $payload['user_cd'] ?? '',
            ]);

            return $result[0][0] ?? [];
        } catch (\Exception $e) {
        }

        return [];
    }

    /**
     * Check if a user has permission to access a route.
     *
     * @param int $user_id
     */
    public static function havePermission(array $functions, string $controller): bool
    {
        try {
            // TO DO
            return true;
        } catch (\Exception $e) {
        }

        return true;
    }

    /**
     * Check if a user can access a function.
     */
    public static function canAccess(string $route_name): bool
    {
        try {
            // TO DO
            return true;
        } catch (\Exception $e) {
        }

        return false;
    }

    /**
     * Generate an authentication token for a user.
     */
    public static function getToken(string $username, array $result): string
    {
        $result['user_cd'] = $username;
        $sub = config('app.name');
        $iat = time();
        $jti = md5($sub . $iat);
        $aud = config('app.url');
        $factory = JWTFactory::sub($sub)
            ->iss(config('app.name'))
            ->iat($iat)
            ->exp(config('jwt.ttl'))
            ->nbf($iat)
            ->jti($jti)
            ->aud($aud)
            ->logindata(json_encode($result));
        $customClaims = [];
        $factory = JWTFactory::customClaims($customClaims);
        $payload = $factory->make();
        $token = JWTAuth::encode($payload);

        return $token->get();
    }
}
