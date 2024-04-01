<?php

namespace App\api\Master\Requests\M004;

use AnsRequest;
use App\api\Master\Models\M004\CustomerDetail;

class SaveCustomerRequest extends AnsRequest
{
    public function rules()
    {
        return [
            'billing_source_cd' => 'required|numeric',
            'customer_nm' => 'required|string|max:50',
            'customer_kn_nm' => 'nullable|string|max:50',
            'customer_ab_nm' => 'nullable|string|max:30',
            'customer_zip' => 'nullable|string|max:8',
            'customer_address1' => 'nullable|string|max:50',
            'customer_address2' => 'nullable|string|max:50',
            'customer_address3' => 'nullable|string|max:100',
            'customer_tel' => 'nullable|string|max:20',
            'customer_fax' => 'nullable|string|max:20',
            'customer_department_nm' => 'nullable|string|max:30',
            'customer_manager_nm' => 'nullable|string|max:30',
            'customer_mail_address' => 'email|nullable|string|max:255',
            'customer_class_div1' => 'nullable|numeric',
            'customer_class_div2' => 'nullable|numeric',
            'customer_class_div3' => 'nullable|numeric',
            'billing_nm' => 'nullable|string|max:50',
            'billing_zip' => 'nullable|string|max:8',
            'billing_address1' => 'nullable|string|max:50',
            'billing_address2' => 'nullable|string|max:50',
            'billing_address3' => 'nullable|string|max:100',
            'billing_tel' => 'nullable|string|max:20',
            'billing_fax' => 'nullable|string|max:20',
            'billing_department_nm' => 'nullable|string|max:30',
            'billing_manager_nm' => 'nullable|string|max:30',
            'billing_mail_address' => 'nullable|string|max:255',
            'billing_closing_div' => 'nullable|numeric',
            'transfer_date1' => 'nullable|numeric',
            'transfer_date2' => 'nullable|numeric',
            'sales_employee_cd' => 'nullable|string|max:5',
            'price_list' => 'nullable|numeric',
            'reason_for_closure' => 'nullable|string|max:50',
            'remarks' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        $message = parent::messages();

        return array_merge($message, [
            'billing_source_cd.required' => 'E001',
            'customer_nm.required' => 'E001',
            'customer_nm.max' => 'E010|50',
            'customer_kn_nm.max' => 'E010|50',
            'customer_ab_nm.max' => 'E010|30',
            'customer_zip.max' => 'E010|8',
            'customer_address1.max' => 'E010|50',
            'customer_address2.max' => 'E010|50',
            'customer_address3.max' => 'E010|100',
            'customer_tel.max' => 'E010|20',
            'customer_fax.max' => 'E010|20',
            'customer_department_nm.max' => 'E010|30',
            'customer_manager_nm.max' => 'E010|30',
            'customer_mail_address.max' => 'email|E010|255',
            'billing_nm.max' => 'E010|50',
            'billing_zip.max' => 'E010|8',
            'billing_address1.max' => 'E010|50',
            'billing_address2.max' => 'E010|50',
            'billing_address3.max' => 'E010|100',
            'billing_tel.max' => 'E010|20',
            'billing_fax.max' => 'E010|20',
            'billing_department_nm.max' => 'E010|30',
            'billing_manager_nm.max' => 'E010|30',
            'billing_mail_address.max' => 'E010|255',
            'sales_employee_cd.max' => 'E010|5',
            'reason_for_closure.max' => 'E010|50',
            'remarks.max' => 'E010|100',
        ]);
    }

    public function makeCustomer(): CustomerDetail
    {
        return new CustomerDetail($this->all());
    }
}
