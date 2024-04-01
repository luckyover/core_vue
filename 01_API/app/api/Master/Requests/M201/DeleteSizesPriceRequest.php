<?php

namespace App\api\Master\Requests\M201;

use AnsRequest;
use App\api\Master\Models\M201\DeleteSizesPrice;

class DeleteSizesPriceRequest extends AnsRequest
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

    public function makeData(): DeleteSizesPrice
    {
        return new DeleteSizesPrice($this->all());
    }
}
