<?php

namespace App\api\Master\Resources\M301;

use AnsResponse;
use App\api\Master\Models\M301\ProcessPrice;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(schema="M301ProcessPriceResource")
 */
class ProcessPriceResource extends AnsResponse
{
    public function __construct(array $data)
    {
        $this->data = collect();
        foreach ($data as $key => $val) {
            $this->data->push(new ProcessPrice($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M301ProcessPrice")
     * )
     */
    public Collection $data;
}
