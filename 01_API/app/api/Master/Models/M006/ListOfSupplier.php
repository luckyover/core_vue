<?php

namespace App\api\Master\Models\M006;

use AnsModel;
use App\Models\AnsPaging;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M006ListOfSupplier",
 *      description="Data have list of suppliers and data for paging"
 * )
 */
class ListOfSupplier extends AnsModel
{
    public function __construct()
    {
        $this->suppliers = collect(new SupplierSearch);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M006SupplierSearch")
     * )
     */
    public Collection $suppliers;

    /**
     * @OA\Property(ref="#/components/schemas/AnsPaging")
     */
    public AnsPaging $paging;

    public function setSuppliers(array $input)
    {
        $this->suppliers = collect();

        foreach ($input as $key => $val) {
            $this->suppliers->push(new SupplierSearch($val));
        }
    }
}
