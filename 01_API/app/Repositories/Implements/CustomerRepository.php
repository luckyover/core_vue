<?php

namespace App\Repositories\Implements;

use App\Repositories\ICustomerRepository;
use App\Utility\Constants;
use DbService;

class CustomerRepository implements ICustomerRepository
{
    public function find($customer_cd)
    {
        if (!is_numeric($customer_cd)) {
            return [];
        }
        $result = DbService::execSQL('SPC_M004_INQ1', [
            'customer_cd' => $customer_cd,
        ]);

        return $result[0][0] ?? [];
    }

    public function search($condition)
    {
        $result = DbService::execSQL('SPC_M004_INQ2', [
            'customer_cd' => $condition->inq_customer_cd,
            'billing_source_cd' => $condition->inq_billing_source_cd,
            'customer_nm' => $condition->inq_customer_nm,
            'customer_kn_nm' => $condition->inq_customer_kn_nm,
            'customer_ab_nm' => $condition->inq_customer_ab_nm,
            'customer_tel' => $condition->inq_customer_tel,
            'customer_class_div1' => $condition->inq_customer_class_div1,
            'customer_class_div2' => $condition->inq_customer_class_div2,
            'customer_class_div3' => $condition->inq_customer_class_div3,
            'billing_closing_div' => $condition->inq_billing_closing_div,
            'sales_employee_cd' => $condition->inq_sales_employee_cd,
            'page_size' => $condition->page_size,
            'page' => $condition->page,
            'sort_column' => $condition->sort_column,
            'sort_type' => $condition->sort_type,
        ]);

        return $result;
    }

    public function suggestSearch($search)
    {
        $result = DbService::execSQL('SPC_M004_INQ3', [
            'search' => $search,
            'rows' => Constants::MAX_ROW_SUGGEST,
        ]);

        return $result[0] ?? [];
    }

    public function save($customer)
    {
        $result = DbService::execSQL('SPC_M004_ACT1', [
            'customer_cd' => $customer->customer_cd,
            'billing_source_cd' => $customer->billing_source_cd,
            'customer_nm' => $customer->customer_nm,
            'customer_kn_nm' => $customer->customer_kn_nm,
            'customer_ab_nm' => $customer->customer_ab_nm,
            'customer_zip' => $customer->customer_zip,
            'customer_address1' => $customer->customer_address1,
            'customer_address2' => $customer->customer_address2,
            'customer_address3' => $customer->customer_address3,
            'customer_tel' => $customer->customer_tel,
            'customer_fax' => $customer->customer_fax,
            'customer_department_nm' => $customer->customer_department_nm,
            'customer_manager_nm' => $customer->customer_manager_nm,
            'customer_mail_address' => $customer->customer_mail_address,
            'customer_class_div1' => $customer->customer_class_div1,
            'customer_class_div2' => $customer->customer_class_div2,
            'customer_class_div3' => $customer->customer_class_div3,
            'billing_nm' => $customer->billing_nm,
            'billing_zip' => $customer->billing_zip,
            'billing_address1' => $customer->billing_address1,
            'billing_address2' => $customer->billing_address2,
            'billing_address3' => $customer->billing_address3,
            'billing_tel' => $customer->billing_tel,
            'billing_fax' => $customer->billing_fax,
            'billing_department_nm' => $customer->billing_department_nm,
            'billing_manager_nm' => $customer->billing_manager_nm,
            'billing_mail_address' => $customer->billing_mail_address,
            'billing_closing_div' => $customer->billing_closing_div,
            'transfer_date1' => $customer->transfer_date1,
            'transfer_date2' => $customer->transfer_date2,
            'sales_employee_cd' => $customer->sales_employee_cd,
            'price_list' => $customer->price_list,
            'reason_for_closure' => $customer->reason_for_closure,
            'remarks' => $customer->remarks,
        ]);
        DbService::hasDatabaseError($result);

        return $result[1][0] ?? [];
    }

    public function delete($customer_cd)
    {
        $result = DbService::execSQL('SPC_M004_ACT2', [
            'customer_cd' => $customer_cd,
        ]);
        DbService::hasDatabaseError($result);

        return $result[0][0] ?? [];
    }
}
