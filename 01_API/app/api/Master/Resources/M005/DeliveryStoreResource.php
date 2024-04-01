<?php

namespace App\api\Master\Resources\M005;

use AnsResponse;

/**
 * @OA\Schema(schema="M005DeliveryStoreResource")
 */
class DeliveryStoreResource extends AnsResponse
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
