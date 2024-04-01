<?php

namespace App\api\Master\Requests\M006;

use AnsRequest;
use App\api\Master\Models\M006\SupplierDetail;
use App\Rules\KatakanaRule;

class SaveSupplierRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'supplier_div' => 'required|numeric',
            'supplier_nm' => 'required|max:50',
            'supplier_kn_nm' => [
                'nullable',
                'string',
                'max:50',
                new KatakanaRule,
            ],
            'supplier_ab_nm' => 'nullable|string|max:30',
            'supplier_zip' => 'nullable|string|max:8',
            'supplier_address1' => 'nullable|string|max:50',
            'supplier_address2' => 'nullable|string|max:50',
            'supplier_address3' => 'nullable|string|max:100',
            'supplier_tel' => 'nullable|string|max:20',
            'supplier_fax' => 'nullable|string|max:20',
            'supplier_department_nm' => 'nullable|string|max:30',
            'supplier_manager_nm' => 'nullable|string|max:30',
            'supplier_mail_address' => 'email|nullable|string|max:255',
            'supplier_class_div1' => 'nullable|numeric',
            'supplier_class_div2' => 'nullable|numeric',
            'supplier_class_div3' => 'nullable|numeric',
            'supplier_closing_div' => 'nullable|numeric',
            'transfer_date1' => 'nullable|numeric',
            'transfer_date2' => 'nullable|numeric',
            'remarks' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'supplier_nm.required' => 'E001',
            'supplier_nm.max' => 'E010|50',
            'supplier_kn_nm.max' => 'E010|50',
            'supplier_ab_nm.max' => 'E010|30',
            'supplier_zip.max' => 'E010|8',
            'supplier_address1.max' => 'E010|50',
            'supplier_address2.max' => 'E010|50',
            'supplier_address3.max' => 'E010|100',
            'supplier_tel.max' => 'E010|20',
            'supplier_fax.max' => 'E010|20',
            'supplier_department_nm.max' => 'E010|30',
            'supplier_manager_nm.max' => 'E010|30',
            'supplier_mail_address.email' => 'E002',
            'supplier_mail_address.max' => 'E010|255',
            'remarks.max' => 'E010|100',
        ]);
    }

    public function makeSupplier(): SupplierDetail
    {
        return new SupplierDetail($this->all());
    }
}
