<?php

namespace App\api\Master\Resources\M101;

use AnsResponse;
use App\api\Master\Models\M101\Item;

/**
 * @OA\Schema(schema="M101ReferNameItemResource")
 */
class ReferNameItemResource extends AnsResponse
{
    public function __construct(Item $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M101Item")
     */
    public Item $data;
}
