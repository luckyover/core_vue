<?php

namespace App\Models;

/**
 * @OA\Schema(schema="AnsException", description="Information of error in API")
 */
class AnsException
{
    /**
     * @OA\Property(
     *      description="Class have exception",
     *      example="DataResponse"
     * )
     */
    public string $instance = '';

    /**
     * @OA\Property(
     *      description="Line in class have exception",
     *      example="123"
     * )
     */
    public int $line = 0;

    /**
     * @OA\Property(
     *      description="File have exception",
     *      example="DataResponse.php"
     * )
     */
    public string $file = '';

    /**
     * @OA\Property(
     *      description="Code of exception",
     *      example="123"
     * )
     */
    public int|string $code = 0;

    /**
     * @OA\Property(
     *      description="Message for error",
     *      example="Undefined array key"
     * )
     */
    public string $message = '';
}
