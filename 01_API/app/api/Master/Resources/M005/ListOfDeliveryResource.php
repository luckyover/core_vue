<?php

namespace App\api\Master\Resources\M005;

use AnsResponse;
use App\api\Master\Models\M005\ListOfDelivery;

/**
 * @OA\Schema(schema="M005ListOfDeliveryResource")
 */
class ListOfDeliveryResource extends AnsResponse
{
    public function __construct(ListOfDelivery $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M005ListOfDelivery")
     */
    public ListOfDelivery $data;
}
