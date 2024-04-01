<?php

namespace App\api\Master\Models\M004;

use AnsModel;
use App\Models\AnsPaging;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M004ListOfCustomers",
 *      description="Data have list of customers and data for paging"
 * )
 */
class ListOfCustomers extends AnsModel
{
    public function __construct()
    {
        $this->customers = collect(new CustomerSearch);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M004CustomerSearch")
     * )
     */
    public Collection $customers;

    /**
     * @OA\Property(ref="#/components/schemas/AnsPaging")
     */
    public AnsPaging $paging;

    public function setCustomers(array $input)
    {
        $this->customers = collect();

        foreach ($input as $key => $val) {
            $this->customers->push(new CustomerSearch($val));
        }
    }
}
