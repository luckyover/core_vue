<?php

namespace App\api\System\Resources\Login;

use AnsResponse;
use App\api\System\Models\Login\Token;

/**
 * @OA\Schema(schema="LoginResource")
 */
class LoginResource extends AnsResponse
{
    public function __construct(Token $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/JwtToken")
     */
    public Token $data;
}
