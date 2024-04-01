<?php

namespace App\api\Master\Requests\M301;

use AnsRequest;
use App\api\Master\Models\M301\PostProcessPrice;

class SaveProcessPriceRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'process_prices.*.item_cd' => 'required|string|max:30',
            'process_prices.*.category_div' => 'required|numeric',
            'process_prices.*.material_div' => 'required|numeric',
            'process_prices.*.processing_place_div' => 'required|numeric',
            'process_prices.*.number_sheet_fr' => 'required|numeric',
            'process_prices.*.number_sheet_to' => 'required|numeric',
            'process_prices.*.color_div' => 'required|numeric',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'process_prices.*.item_cd.required' => 'E001',
            'process_prices.*.item_cd.max' => 'E010|30',
            'process_prices.*.category_div.required' => 'E001',
            'process_prices.*.material_div.required' => 'E001',
            'process_prices.*.processing_place_div.required' => 'E001',
            'process_prices.*.number_sheet_fr.required' => 'E001',
            'process_prices.*.number_sheet_to.required' => 'E001',
            'process_prices.*.color_div.required' => 'E001',
        ]);
    }

    public function makeData(): PostProcessPrice
    {
        return new PostProcessPrice($this->all());
    }
}
