<?php

namespace App\Services;

class AnsService
{
    public function __construct()
    {
    }

    /**
     * Check if a string is empty.
     */
    public static function isEmpty(string|int|null $str, bool $isCheckZero = false): bool
    {
        return $str === null || $str === '' || ($isCheckZero && ($str === 0 || $str === '0'));
    }

    /**
     * Generate a random string of specified length.
     */
    public static function randomString(int $n = 100): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    /**
     * Generate a UUID (Universally Unique Identifier).
     */
    public static function genUuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF),

            // 16 bits for "time_mid"
            mt_rand(0, 0xFFFF),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0FFF) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3FFF) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF), mt_rand(0, 0xFFFF)
        );
    }
}
