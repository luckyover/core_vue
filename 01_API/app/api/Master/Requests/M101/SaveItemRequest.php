<?php

namespace App\api\Master\Requests\M101;

use AnsRequest;
use App\api\Master\Models\M101\ItemDetail;
use App\Rules\KatakanaRule;

class SaveItemRequest extends AnsRequest
{
    public function rules()
    {
        $rule = [
            'item_cd' => 'required|string|max:30',
            'item_nm' => 'required|string|max:50',
            'item_kn_nm' => [
                'nullable',
                'string',
                'max:50',
                new KatakanaRule,
            ],
            'item_ab_nm' => 'nullable|string|max:30',
            'color_nm' => 'nullable|string|max:30',
            'color_kn_nm' => [
                'nullable',
                'string',
                'max:30',
                new KatakanaRule,
            ],
            'color_ab_nm' => 'nullable|string|max:20',
            'supplier_item_cd' => 'nullable|string|max:30',
            'remarks' => 'nullable|string|max:100',
        ];
        $input = $this->all();
        if ($input['item_class_div'] === 1) {
            $rule['sizes.*.size_cd'] = 'required|string|max:10';
        }

        return $rule;
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'item_cd.required' => 'E001',
            'item_cd.max' => 'E010|30',
            'color_cd.max' => 'E010|10',
            'item_nm.required' => 'E001',
            'item_nm.max' => 'E010|50',
            'item_kn_nm.max' => 'E010|50',
            'item_ab_nm.max' => 'E010|30',
            'color_nm.max' => 'E010|30',
            'color_kn_nm.max' => 'E010|30',
            'color_ab_nm.max' => 'E010|20',
            'supplier_cd.max' => 'E010|80',
            'remarks.max' => 'E010|100',
            'sizes.*.size_cd.required' => 'E001',
        ]);
    }

    public function makeItem(): ItemDetail
    {
        return new ItemDetail($this->all());
    }
}
