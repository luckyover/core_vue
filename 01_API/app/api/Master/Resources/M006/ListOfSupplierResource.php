<?php

namespace App\api\Master\Resources\M006;

use AnsResponse;
use App\api\Master\Models\M006\ListOfSupplier;

/**
 * @OA\Schema(schema="M006ListOfSupplierResource")
 */
class ListOfSupplierResource extends AnsResponse
{
    public function __construct(ListOfSupplier $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M006ListOfSupplier")
     */
    public ListOfSupplier $data;
}
