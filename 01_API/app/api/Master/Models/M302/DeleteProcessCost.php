<?php

namespace App\api\Master\Models\M302;

use AnsModel;
use App\Api\Master\Models\M302\ProcessCostDetail;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M302DeleteProcessCost",
 *      description="Data cost of product"
 * )
 */
class DeleteProcessCost extends AnsModel
{
    public function __construct($data)
    {
        $this->costs = collect();
        foreach ($data['costs'] ?? [] as $key => $val) {
            $this->costs->push(new ProcessCostDetail($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M302ProcessCostDetail")
     * )
     */
    public Collection $costs;
}
