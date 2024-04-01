<?php

namespace App\api\Master\Resources\M301;

use AnsResponse;
use App\api\Master\Models\M301\ProcessPrice;

/**
 * @OA\Schema(schema="M301ProcessPriceAct1Resource")
 */
class ProcessPriceAct1Resource extends AnsResponse
{
    public function __construct(ProcessPrice $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M301ProcessPrice")
     */
    public ProcessPrice $data;
}
