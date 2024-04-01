<?php

namespace App\api\Master\Requests\M301;

use AnsRequest;
use App\api\Master\Models\M301\DeleteProcessPrice;

class DeleteProcessPriceRequest extends AnsRequest
{
    public function rules()
    {
        return [

        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [

        ]);
    }

    public function makeData(): DeleteProcessPrice
    {
        return new DeleteProcessPrice($this->all());
    }
}
