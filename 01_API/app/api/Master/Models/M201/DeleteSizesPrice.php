<?php

namespace App\api\Master\Models\M201;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M201DeleteSizesPrice",
 *      description="Data cost of size price"
 * )
 */
class DeleteSizesPrice extends AnsModel
{
    public function __construct($data)
    {
        $this->sizes_prices = collect();
        foreach ($data['sizes_prices'] ?? [] as $key => $val) {
            $this->sizes_prices->push(new SizesPriceDetail($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M201SizesPriceDetail")
     * )
     */
    public Collection $sizes_prices;
}
