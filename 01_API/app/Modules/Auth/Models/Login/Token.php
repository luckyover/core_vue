<?php

namespace App\Modules\Auth\Models\Login;

use AnsModel;

class Token extends AnsModel
{
    public ?string $token;

    public int $timeout;

    public ?string $urlBefore;
}
