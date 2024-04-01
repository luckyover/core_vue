<?php

namespace App\api\System\Requests\M002;

use AnsRequest;
use App\api\System\Models\M002\UserDetail;
use App\Rules\KatakanaRule;

class SaveUserRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'user_cd' => 'required|string|max:5',
            'password' => 'required|string|max:50',
            'user_nm' => 'required|string|max:50',
            'user_kn_nm' => [
                'nullable',
                'string',
                'max:50',
                new KatakanaRule,
            ],
            'user_ab_nm' => 'nullable|string|max:30',
            'tel' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'mailaddress' => 'email|nullable|string|max:255',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'user_cd.required' => 'E001',
            'user_cd.max' => 'E010|5',
            'password.required' => 'E001',
            'password.max' => 'E010|50',
            'user_nm.required' => 'E001',
            'user_nm.max' => 'E010|50',
            'user_kn_nm.max' => 'E010|50',
            'user_ab_nm.max' => 'E010|30',
            'tel.max' => 'E010|20',
            'fax.max' => 'E010|20',
            'mailaddress.email' => 'E002',
            'mailaddress.max' => 'E010|255',
        ]);
    }

    public function makeUser(): UserDetail
    {
        return new UserDetail($this->all());
    }
}
