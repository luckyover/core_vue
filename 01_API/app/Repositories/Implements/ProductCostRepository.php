<?php

namespace App\Repositories\Implements;

use App\Repositories\IProductCostRepository;
use DbService;

class ProductCostRepository implements IProductCostRepository
{
    public function __construct()
    {
    }

    public function search($input)
    {
        $result = DbService::execSQL('SPC_M202_INQ1', [
            'item_cd' => $input->item_cd,
            'item_nm' => $input->item_nm,
            'color_cd' => $input->color_cd,
            'size_cd' => $input->size_cd,
            'supplier_cd' => $input->supplier_cd,
            'supplier_nm' => $input->supplier_nm,
        ]);

        return $result[0] ?? [];
    }

    public function save($input): array
    {
        $result = DbService::execSQL('SPC_M202_ACT1', [
            'costs' => json_encode($input->costs),
            'updCost' => json_encode($input->updCost),
            'delCost' => json_encode($input->delCost),
        ]);

        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }

    public function delete($input): array
    {
        $result = DbService::execSQL('SPC_M202_ACT2', [
            'costs' => json_encode($input->costs),
        ]);

        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }
}
