<?php

namespace App\api\Master\Resources\M201;

use AnsResponse;
use App\api\Master\Models\M201\SizesPrice;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(schema="M201SizesPriceResource")
 */
class SizesPriceResource extends AnsResponse
{
    public function __construct(array $data)
    {
        $this->data = collect();
        foreach ($data as $key => $val) {
            $this->data->push(new SizesPrice($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M201SizesPrice")
     * )
     */
    public Collection $data;
}
