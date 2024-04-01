<?php

namespace App\api\Master\Requests\M005;

use AnsRequest;
use App\api\Master\Models\M005\DeliveryDetail;
use App\Rules\KatakanaRule;

class SaveDeliveryRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'delivery_nm' => 'required|string|max:50',
            'delivery_kn_nm' => [
                'nullable',
                'string',
                'max:50',
                new KatakanaRule,
            ],
            'delivery_ab_nm' => 'nullable|string|max:30',
            'delivery_zip' => 'nullable|string|max:8',
            'delivery_address1' => 'nullable|string|max:50',
            'delivery_address2' => 'nullable|string|max:50',
            'delivery_address3' => 'nullable|string|max:100',
            'delivery_tel' => 'nullable|string|max:20',
            'delivery_fax' => 'nullable|string|max:20',
            'delivery_department_nm' => 'nullable|string|max:30',
            'delivery_manager_nm' => 'nullable|string|max:30',
            'delivery_mail_address' => 'email|nullable|string|max:255',
            'remarks' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'delivery_nm.required' => 'E001',
            'delivery_nm.max' => 'E010|50',
            'delivery_kn_nm.max' => 'E010|50',
            'delivery_ab_nm.max' => 'E010|30',
            'delivery_zip.max' => 'E010|8',
            'delivery_address1.max' => 'E010|50',
            'delivery_address2.max' => 'E010|50',
            'delivery_address3.max' => 'E010|100',
            'delivery_tel.max' => 'E010|20',
            'delivery_fax.max' => 'E010|20',
            'delivery_department_nm.max' => 'E010|30',
            'delivery_manager_nm.max' => 'E010|30',
            'delivery_mail_address.email' => 'E002',
            'delivery_mail_address.max' => 'E010|255',
            'remarks.max' => 'E010|100',
        ]);
    }

    public function makeDelivery(): DeliveryDetail
    {
        return new DeliveryDetail($this->all());
    }
}
