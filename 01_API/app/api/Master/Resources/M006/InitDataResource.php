<?php

namespace App\api\Master\Resources\M006;

use AnsResponse;
use App\api\Master\Models\M006\InitData;

/**
 * @OA\Schema(schema="M006InitDataResource")
 */
class InitDataResource extends AnsResponse
{
    public function __construct(InitData $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M006InitData")
     */
    public InitData $data;
}
