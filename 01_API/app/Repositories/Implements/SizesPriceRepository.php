<?php

namespace App\Repositories\Implements;

use App\Repositories\ISizesPriceRepository;
use DbService;

class SizesPriceRepository implements ISizesPriceRepository
{
    public function search($search)
    {
        $result = DbService::execSQL('SPC_M201_INQ1', [
            'item_cd' => $search->item_cd,
            'color_cd' => $search->color_cd,
            'item_nm' => $search->item_nm,
            'price_list' => $search->price_list,
        ]);

        return $result[0] ?? [];
    }

    public function save($input): array
    {
        $result = DbService::execSQL('SPC_M201_ACT1', [
            'sizes_prices' => json_encode($input->sizes_prices),
            'update_sizes_prices' => json_encode($input->update_sizes_prices),
            'delete_sizes_price' => json_encode($input->delete_sizes_price),
        ]);
        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }

    public function delete($input): array
    {
        $result = DbService::execSQL('SPC_M201_ACT2', [
            'sizes_prices' => json_encode($input->sizes_prices),
        ]);

        DbService::hasDatabaseError($result);

        return $result[0] ?? [];
    }
}
