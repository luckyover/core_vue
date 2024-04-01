<?php

namespace App\api\Master\Resources\M101;

use AnsResponse;
use App\api\Master\Models\M101\M101Data;

/**
 * @OA\Schema(schema="M101ItemDetailResource")
 */
class ItemDetailResource extends AnsResponse
{
    public function __construct(M101Data $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M101Data")
     */
    public M101Data $data;
}
