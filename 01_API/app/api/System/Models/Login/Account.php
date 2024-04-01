<?php

namespace App\api\System\Models\Login;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="LoginAccount",
 *      description="Data input for login"
 * )
 */
class Account extends AnsModel
{
    /**
     * @OA\Property(example="809")
     */
    public ?string $username = '';

    /**
     * @OA\Property(example="123")
     */
    public ?string $password = '';
}
