<?php

namespace App\api\Master\Resources\M004;

use AnsResponse;
use App\api\Master\Models\M004\ListOfCustomers;

/**
 * @OA\Schema(schema="M004ListOfCustomersResource")
 */
class ListOfCustomersResource extends AnsResponse
{
    public function __construct(ListOfCustomers $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M004ListOfCustomers")
     */
    public ListOfCustomers $data;
}
