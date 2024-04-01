<?php

namespace App\api\Master\Resources\M006;

use AnsResponse;

/**
 * @OA\Schema(schema="M006SupplierAct1Resource")
 */
class SupplierAct1Resource extends AnsResponse
{
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(example="1")
     */
    public string $data;
}
