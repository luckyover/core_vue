<?php

namespace App\api\System\Requests\M002;

use AnsRequest;
use App\api\System\Models\M002\SearchCondition;

class SearchUserRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'mailaddress' => 'email|nullable|string|max:255',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'mailaddress.email' => 'E002',
            'mailaddress.max' => 'E010|255',
        ]);
    }

    public function makeCondition(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
