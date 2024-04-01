<?php

namespace App\api\Master\Resources\M302;

use AnsResponse;
use App\api\Master\Models\M302\ProcessCost;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(schema="M302ProcessCostResource")
 */
class ProcessCostResource extends AnsResponse
{
    public function __construct(array $data)
    {
        $this->data = collect();
        foreach ($data as $key => $val) {
            $this->data->push(new ProcessCost($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M302ProcessCost")
     * )
     */
    public Collection $data;
}
