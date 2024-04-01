<?php

namespace App\Repositories\Implements;

use App\Repositories\IProcessCostRepository;
use DbService;

class ProcessCostRepository implements IProcessCostRepository
{
    public function __construct()
    {
    }

    public function search($input): array
    {
        $result = DbService::execSQL('SPC_M302_INQ1', [
            'supplier_cd' => $input->supplier_cd,
            'supplier_nm' => $input->supplier_nm,
            'item_cd' => $input->item_cd,
            'item_nm' => $input->item_nm,
            'category_div' => $input->category_div,
            'material_div' => $input->material_div,
            'processing_place_div' => $input->processing_place_div,
        ]);

        return $result[0] ?? [];
    }

    public function save($input): array
    {
        $result = DbService::execSQL('SPC_M302_ACT1', [
            'costs' => json_encode($input->costs),
            'update_costs' => json_encode($input->update_costs),
            'delete_costs' => json_encode($input->delete_costs),
        ]);

        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }

    public function delete($input): array
    {
        $result = DbService::execSQL('SPC_M302_ACT2', [
            'costs' => json_encode($input->costs),
        ]);

        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }
}
