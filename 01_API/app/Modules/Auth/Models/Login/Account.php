<?php

namespace App\Modules\Auth\Models\Login;

use AnsModel;

class Account extends AnsModel
{
    public ?string $username = '';

    public ?string $password = '';
}
