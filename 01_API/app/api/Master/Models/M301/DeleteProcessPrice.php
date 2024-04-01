<?php

namespace App\api\Master\Models\M301;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M301DeleteProcessPrice",
 *      description="Data cost of process price"
 * )
 */
class DeleteProcessPrice extends AnsModel
{
    public function __construct($data)
    {
        $this->process_prices = collect();
        foreach ($data['process_prices'] ?? [] as $key => $val) {
            $this->process_prices->push(new ProcessPriceDetail($val));
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
}
