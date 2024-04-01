<?php

namespace App\Modules\Auth\Resources\Login;

use AnsResponse;
use App\Modules\Auth\Models\Login\Token;

class LoginResource extends AnsResponse
{
    public function __construct(Token $data)
    {
        $this->data = $data;
    }

    public Token $data;
}
