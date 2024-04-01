<?php

namespace App\api\Master\Resources\M101;

use AnsResponse;
use App\api\Master\Models\M101\InitData;

/**
 * @OA\Schema(schema="M101InitDataResource")
 */
class InitDataResource extends AnsResponse
{
    public function __construct(InitData $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M101InitData")
     */
    public InitData $data;
}
