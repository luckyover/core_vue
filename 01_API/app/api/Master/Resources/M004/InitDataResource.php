<?php

namespace App\api\Master\Resources\M004;

use AnsResponse;
use App\api\Master\Models\M004\InitData;

/**
 * @OA\Schema(schema="M004InitDataResource")
 */
class InitDataResource extends AnsResponse
{
    public function __construct(InitData $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M004InitData")
     */
    public InitData $data;
}
