<?php

namespace App\api\Master\Models\M302;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M302PostProcessCost",
 *      description="Data cost of product"
 * )
 */
class PostProcessCost extends AnsModel
{
    public function __construct($data)
    {
        $this->costs = collect();
        foreach ($data['costs'] ?? [] as $key => $val) {
            $this->costs->push(new ProcessCostDetail($val));
        }

        $this->update_costs = collect();
        foreach ($data['update_costs'] ?? [] as $key => $val) {
            $this->update_costs->push(new ProcessCostDetail($val));
        }

        $this->delete_costs = collect();
        foreach ($data['delete_costs'] ?? [] as $key => $val) {
            $this->delete_costs->push(new ProcessCostDetail($val));
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

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M302ProcessCostDetail")
     * )
     */
    public Collection $update_costs;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M302ProcessCostDetail")
     * )
     */
    public Collection $delete_costs;
}
