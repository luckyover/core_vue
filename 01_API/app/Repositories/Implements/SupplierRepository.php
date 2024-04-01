<?php

namespace App\Repositories\Implements;

use App\Repositories\ISupplierRepository;
use App\Utility\Constants;
use DbService;

class SupplierRepository implements ISupplierRepository
{
    public function find($supplier_cd, $options)
    {
        if (!is_numeric($supplier_cd)) {
            return [];
        }
        $result = DbService::execSQL('SPC_M006_INQ1', [
            'supplier_cd' => $supplier_cd,
            'supplier_div' => $options['inq_supplier_div'] ?? 0,
        ]);

        return $result[0][0] ?? [];
    }

    public function search($condition)
    {
        $result = DbService::execSQL('SPC_M006_INQ2', [
            'supplier_cd' => $condition->inq_supplier_cd,
            'supplier_div' => $condition->inq_supplier_div,
            'supplier_nm' => $condition->inq_supplier_nm,
            'supplier_kn_nm' => $condition->inq_supplier_kn_nm,
            'supplier_ab_nm' => $condition->inq_supplier_ab_nm,
            'supplier_tel' => $condition->inq_supplier_tel,
            'supplier_class_div1' => $condition->inq_supplier_class_div1,
            'supplier_class_div2' => $condition->inq_supplier_class_div2,
            'supplier_class_div3' => $condition->inq_supplier_class_div3,
            'page_size' => $condition->page_size,
            'page' => $condition->page,
            'sort_column' => $condition->sort_column,
            'sort_type' => $condition->sort_type,
        ]);

        return $result;
    }

    public function suggestSearch($input)
    {
        $result = DbService::execSQL('SPC_M006_INQ3', [
            'search' => $input['search'] ?? '',
            'supplier_div' => $input['inq_supplier_div'] ?? 0,
            'rows' => Constants::MAX_ROW_SUGGEST,
        ]);

        return $result[0] ?? [];
    }

    public function save($supplier)
    {
        $result = DbService::execSQL('SPC_M006_ACT1', [
            'supplier_cd' => $supplier->supplier_cd,
            'supplier_div' => $supplier->supplier_div,
            'supplier_nm' => $supplier->supplier_nm,
            'supplier_kn_nm' => $supplier->supplier_kn_nm,
            'supplier_ab_nm' => $supplier->supplier_ab_nm,
            'supplier_zip' => $supplier->supplier_zip,
            'supplier_address1' => $supplier->supplier_address1,
            'supplier_address2' => $supplier->supplier_address2,
            'supplier_address3' => $supplier->supplier_address3,
            'supplier_tel' => $supplier->supplier_tel,
            'supplier_fax' => $supplier->supplier_fax,
            'supplier_department_nm' => $supplier->supplier_department_nm,
            'supplier_manager_nm' => $supplier->supplier_manager_nm,
            'supplier_mail_address' => $supplier->supplier_mail_address,
            'supplier_class_div1' => $supplier->supplier_class_div1,
            'supplier_class_div2' => $supplier->supplier_class_div2,
            'supplier_class_div3' => $supplier->supplier_class_div3,
            'supplier_closing_div' => $supplier->supplier_closing_div,
            'transfer_date1' => $supplier->transfer_date1,
            'transfer_date2' => $supplier->transfer_date2,
            'remarks' => $supplier->remarks,
        ]);

        DbService::hasDatabaseError($result);

        return $result[1][0] ?? [];
    }

    public function delete($supplier_cd)
    {
        $result = DbService::execSQL('SPC_M006_ACT2', [
            'supplier_cd' => $supplier_cd,
        ]);
        DbService::hasDatabaseError($result);

        return $result[0][0] ?? [];
    }
}
