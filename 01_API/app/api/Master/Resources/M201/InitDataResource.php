<?php

namespace App\api\Master\Resources\M201;

use AnsResponse;
use App\api\Master\Models\M201\InitData;

/**
 * @OA\Schema(schema="M201InitDataResource")
 */
class InitDataResource extends AnsResponse
{
    public function __construct(InitData $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M201InitData")
     */
    public InitData $data;
}
