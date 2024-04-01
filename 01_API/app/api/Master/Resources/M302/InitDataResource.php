<?php

namespace App\api\Master\Resources\M302;

use AnsResponse;
use App\api\Master\Models\M302\InitData;

/**
 * @OA\Schema(schema="M302InitDataResource")
 */
class InitDataResource extends AnsResponse
{
    public function __construct(InitData $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M302InitData")
     */
    public InitData $data;
}
