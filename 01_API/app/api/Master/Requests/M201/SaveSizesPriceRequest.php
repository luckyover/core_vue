<?php

namespace App\api\Master\Requests\M201;

use AnsRequest;
use App\api\Master\Models\M201\PostSizesPrice;

class SaveSizesPriceRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'sizes_prices.*.item_cd' => 'required|string|max:30',
            'sizes_prices.*.color_cd' => 'nullable|string|max:10',
            'sizes_prices.*.price_list' => 'required|numeric',
            'sizes_prices.*.size_cd' => 'required|string|max:10',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'sizes_prices.*.item_cd.required' => 'E001',
            'sizes_prices.*.price_list.required' => 'E001',
            'sizes_prices.*.size_cd.required' => 'E001',
            'color_cd.max' => 'E010|10',
        ]);
    }

    public function makeData(): PostSizesPrice
    {
        return new PostSizesPrice($this->all());
    }
}
