<?php

namespace App\api\Master\Resources\M004;

use AnsResponse;
use App\api\Master\Models\M004\Customer;

/**
 * @OA\Schema(schema="M004CustomerDetailResource")
 */
class CustomerDetailResource extends AnsResponse
{
    public function __construct(Customer $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M004Customer")
     */
    public Customer $data;
}
