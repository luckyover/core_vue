<?php

namespace App\api\Master\Models\M301;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M301PostProcessPrice",
 *      description="Data cost of ProcessPrice"
 * )
 */
class PostProcessPrice extends AnsModel
{
    public function __construct($data)
    {
        $this->process_prices = collect();
        foreach ($data['process_prices'] ?? [] as $key => $val) {
            $this->process_prices->push(new ProcessPriceDetail($val));
        }

        $this->update_process_prices = collect();
        foreach ($data['update_process_prices'] ?? [] as $key => $val) {
            $this->update_process_prices->push(new ProcessPriceDetail($val));
        }

        $this->delete_process_price = collect();
        foreach ($data['delete_process_price'] ?? [] as $key => $val) {
            $this->delete_process_price->push(new ProcessPriceDetail($val));
        }
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M301ProcessPriceDetail")
     * )
     */
    public Collection $process_prices;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M301ProcessPriceDetail")
     * )
     */
    public Collection $update_process_prices;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M301ProcessPriceDetail")
     * )
     */
    public Collection $delete_process_price;
}
