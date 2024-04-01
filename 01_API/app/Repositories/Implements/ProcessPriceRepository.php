<?php

namespace App\Repositories\Implements;

use App\Repositories\IProcessPriceRepository;
use DbService;

class ProcessPriceRepository implements IProcessPriceRepository
{
    public function search($search)
    {
        $result = DbService::execSQL('SPC_M301_INQ1', [
            'item_cd' => $search->item_cd,
            'item_nm' => $search->item_nm,
            'category_div' => $search->category_div,
            'material_div' => $search->material_div,
            'processing_place_div' => $search->processing_location_div,
        ]);

        return $result[0] ?? [];
    }

    public function save($input): array
    {
        $result = DbService::execSQL('SPC_M301_ACT1', [
            'process_prices' => json_encode($input->process_prices),
            'update_process_prices' => json_encode($input->update_process_prices),
            'delete_process_price' => json_encode($input->delete_process_price),
        ]);

        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }

    public function delete($input): array
    {
        $result = DbService::execSQL('SPC_M301_ACT2', [
            'process_prices' => json_encode($input->process_prices),
        ]);

        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }
}
