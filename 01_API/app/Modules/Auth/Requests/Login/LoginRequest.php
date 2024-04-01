<?php

namespace App\Modules\Auth\Requests\Login;

use AnsRequest;
use App\Modules\Auth\Models\Login\Account;

class LoginRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'username.required' => 'E001',
            'password.required' => 'E001',
        ]);
    }

    public function makeAccount(): Account
    {
        return new Account($this->all());
    }
}
