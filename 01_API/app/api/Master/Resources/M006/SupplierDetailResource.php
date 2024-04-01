<?php

namespace App\api\Master\Resources\M006;

use AnsResponse;
use App\api\Master\Models\M006\Supplier;

/**
 * @OA\Schema(schema="M006SupplierDetailResource")
 */
class SupplierDetailResource extends AnsResponse
{
    public function __construct(Supplier $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M006Supplier")
     */
    public Supplier $data;
}
