<?php

namespace App\api\System\Resources\M002;

use AnsResponse;
use App\api\System\Models\M002\InitData;

/**
 * @OA\Schema(schema="M002InitDataResource")
 */
class InitDataResource extends AnsResponse
{
    public function __construct(InitData $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M002InitData")
     */
    public InitData $data;
}
