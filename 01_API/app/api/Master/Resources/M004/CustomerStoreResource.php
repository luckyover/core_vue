<?php

namespace App\api\Master\Resources\M004;

use AnsResponse;

/**
 * @OA\Schema(schema="M004CustomerStoreResource")
 */
class CustomerStoreResource extends AnsResponse
{
    public function __construct(string $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(example="00001")
     */
    public string $data;
}
