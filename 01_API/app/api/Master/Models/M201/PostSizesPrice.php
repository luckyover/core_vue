<?php

namespace App\api\Master\Models\M201;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M201PostSizesPrice",
 *      description="Data cost for PostSizePrice"
 * )
 */
class PostSizesPrice extends AnsModel
{
    public function __construct($data)
    {
        $this->sizes_prices = collect();
        foreach ($data['sizes_prices'] ?? [] as $key => $val) {
            $this->sizes_prices->push(new SizesPriceDetail($val));
        }

        $this->update_sizes_prices = collect();
        foreach ($data['update_sizes_prices'] ?? [] as $key => $val) {
            $this->update_sizes_prices->push(new SizesPriceDetail($val));
        }

        $this->delete_sizes_price = collect();
        foreach ($data['delete_sizes_price'] ?? [] as $key => $val) {
            $this->delete_sizes_price->push(new SizesPriceDetail($val));
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

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M201SizesPriceDetail")
     * )
     */
    public Collection $update_sizes_prices;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M201SizesPriceDetail")
     * )
     */
    public Collection $delete_sizes_price;
}
