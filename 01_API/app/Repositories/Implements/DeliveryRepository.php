<?php

namespace App\Repositories\Implements;

use App\Repositories\IDeliveryRepository;
use App\Utility\Constants;
use DbService;

class DeliveryRepository implements IDeliveryRepository
{
    public function find($delivery_cd)
    {
        if (!is_numeric($delivery_cd)) {
            return [];
        }

        $result = DbService::execSQL('SPC_M005_INQ1', [
            'delivery_cd' => $delivery_cd,
        ]);

        return $result[0][0] ?? [];
    }

    public function search($condition)
    {
        $result = DbService::execSQL('SPC_M005_INQ2', [
            'delivery_cd' => $condition->inq_delivery_cd,
            'delivery_nm' => $condition->inq_delivery_nm,
            'delivery_kn_nm' => $condition->inq_delivery_kn_nm,
            'delivery_ab_nm' => $condition->inq_delivery_ab_nm,
            'delivery_tel' => $condition->inq_delivery_tel,
            'page_size' => $condition->page_size,
            'page' => $condition->page,
            'sort_column' => $condition->sort_column,
            'sort_type' => $condition->sort_type,
        ]);

        return $result;
    }

    public function suggestSearch($search)
    {
        $result = DbService::execSQL('SPC_M005_INQ3', [
            'search' => $search,
            'rows' => Constants::MAX_ROW_SUGGEST,
        ]);

        return $result[0] ?? [];
    }

    public function save($delivery)
    {
        $result = DbService::execSQL('SPC_M005_ACT1', [
            'delivery_cd' => $delivery->delivery_cd,
            'delivery_nm' => $delivery->delivery_nm,
            'delivery_kn_nm' => $delivery->delivery_kn_nm,
            'delivery_ab_nm' => $delivery->delivery_ab_nm,
            'delivery_zip' => $delivery->delivery_zip,
            'delivery_address1' => $delivery->delivery_address1,
            'delivery_address2' => $delivery->delivery_address2,
            'delivery_address3' => $delivery->delivery_address3,
            'delivery_tel' => $delivery->delivery_tel,
            'delivery_fax' => $delivery->delivery_fax,
            'delivery_department_nm' => $delivery->delivery_department_nm,
            'delivery_manager_nm' => $delivery->delivery_manager_nm,
            'delivery_mail_address' => $delivery->delivery_mail_address,
            'remarks' => $delivery->remarks,
        ]);
        DbService::hasDatabaseError($result);

        return $result[1][0] ?? [];
    }

    public function delete($delivery_cd)
    {
        $result = DbService::execSQL('SPC_M005_ACT2', [
            'delivery_cd' => $delivery_cd,
        ]);
        DbService::hasDatabaseError($result);

        return $result[0][0] ?? [];
    }
}
