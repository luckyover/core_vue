<?php

namespace App\api\Master\Resources\M005;

use AnsResponse;
use App\api\Master\Models\M005\Delivery;

/**
 * @OA\Schema(schema="M005DeliveryDetailResource")
 */
class DeliveryDetailResource extends AnsResponse
{
    public function __construct(Delivery $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M005Delivery")
     */
    public Delivery $data;
}
