<?php

namespace App\api\Master\Resources\M202;

use AnsResponse;
use App\api\Master\Models\M202\ProductCost;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(schema="M202ProductCostResource")
 */
class ProductCostResource extends AnsResponse
{
    public function __construct(array $data)
    {
        $this->data = collect();
        foreach ($data as $key => $val) {
            $this->data->push(new ProductCost($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M202ProductCost")
     * )
     */
    public Collection $data;
}
