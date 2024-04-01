<?php

namespace App\api\Master\Resources\M301;

use AnsResponse;
use App\api\Master\Models\M301\InitData;

/**
 * @OA\Schema(schema="M301InitDataResource")
 */
class InitDataResource extends AnsResponse
{
    public function __construct(InitData $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M301InitData")
     */
    public InitData $data;
}
