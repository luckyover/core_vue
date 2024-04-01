<?php

namespace App\api\Master\Requests\M302;

use AnsRequest;
use App\api\Master\Models\M302\PostProcessCost;

class SaveProcessCostRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'costs.*.supplier_cd' => 'required',
            'costs.*.supplier_nm' => 'nullable',
            'costs.*.item_cd' => 'required',
            'costs.*.item_nm' => 'nullable',
            'costs.*.category_div' => 'required',
            'costs.*.material_div' => 'required',
            'costs.*.processing_place_div' => 'required',
            'costs.*.number_sheet_fr' => 'required',
            'costs.*.number_sheet_to' => 'required',
            'costs.*.color_div' => 'required',
            'costs.*.sales_amt' => 'required',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'costs.*.supplier_cd.required' => 'E001',
            'costs.*.item_cd.required' => 'E001',
            'costs.*.category_div.required' => 'E001',
            'costs.*.material_div.required' => 'E001',
            'costs.*.processing_place_div.required' => 'E001',
            'costs.*.number_sheet_fr.required' => 'E001',
            'costs.*.number_sheet_to.required' => 'E001',
            'costs.*.color_div.required' => 'E001',
            'costs.*.sales_amt.required' => 'E001',
        ]);
    }

    public function makeData(): PostProcessCost
    {
        return new PostProcessCost($this->all());
    }
}
