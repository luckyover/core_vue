<?php

namespace App\Repositories\Implements;

use App\Repositories\IItemSizeRepository;
use DbService;

class ItemSizeRepository implements IItemSizeRepository
{
    public function __construct()
    {
    }

    public function getSizes($input): array
    {
        $result = DbService::execSQL('SPC_M102_INQ1', [
            'item_cd' => $input->item_cd,
            'color_cd' => $input->color_cd,
        ]);

        return $result[0] ?? [];
    }
}
