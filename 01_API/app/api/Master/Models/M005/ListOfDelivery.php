<?php

namespace App\api\Master\Models\M005;

use AnsModel;
use App\Models\AnsPaging;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M005ListOfDelivery",
 *      description="Data have list of delivery and data for paging"
 * )
 */
class ListOfDelivery extends AnsModel
{
    public function __construct()
    {
        $this->delivery = collect(new DeliverySearch);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M005DeliverySearch")
     * )
     */
    public Collection $delivery;

    /**
     * @OA\Property(ref="#/components/schemas/AnsPaging")
     */
    public AnsPaging $paging;

    public function setDelivery(array $input)
    {
        $this->delivery = collect();

        foreach ($input as $key => $val) {
            $this->delivery->push(new DeliverySearch($val));
        }
    }
}
