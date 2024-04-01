<?php

namespace App\api\Master\Requests\M202;

use AnsRequest;
use App\api\Master\Models\M202\PostProductCost;

class SaveProductCostRequest extends AnsRequest
{
    public function rules()
    {
        return [
            // 'costs.*.item_cd' => 'required|string|max:30',
            // 'costs.*.color_cd' => 'required|string|max:30',
            'costs.*.size_cd' => 'required|string|max:30',
            'costs.*.supplier_cd' => 'required|numeric',
            'costs.*.retail_upd' => 'numeric',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            // 'costs.*.item_cd.required' => 'E001',
            // 'costs.*.color_cd.required' => 'E001',
            'costs.*.size_cd.required' => 'E001',
            'costs.*.supplier_cd.required' => 'E001',
        ]);
    }

    public function makeCondition(): PostProductCost
    {
        return new PostProductCost($this->all());
    }
}
