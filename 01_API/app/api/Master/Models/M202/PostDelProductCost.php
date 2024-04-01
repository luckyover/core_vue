<?php

namespace App\api\Master\Models\M202;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M202PostDelProductCost",
 *      description="Data cost of product"
 * )
 */
class PostDelProductCost extends AnsModel
{
    public function __construct($data)
    {
        $this->costs = collect();
        foreach ($data['costs'] ?? [] as $key => $val) {
            $this->costs->push(new ProductCostDetail($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M202ProductCostDetail")
     * )
     */
    public Collection $costs;
}
