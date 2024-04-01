<?php

namespace App\api\Master\Resources\M101;

use AnsResponse;
use App\api\Master\Models\M101\ListOfItem;

/**
 * @OA\Schema(schema="M101ListOfItemResource")
 */
class ListOfItemResource extends AnsResponse
{
    public function __construct(ListOfItem $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M101ListOfItem")
     */
    public ListOfItem $data;
}
