<?php

namespace App\api\Master\Models\M101;

use AnsModel;
use App\Models\AnsPaging;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M101ListOfItem",
 *      description="Data have list of items and data for paging"
 * )
 */
class ListOfItem extends AnsModel
{
    public function __construct()
    {
        $this->items = collect(new ItemSearch);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M101ItemSearch")
     * )
     */
    public Collection $items;

    /**
     * @OA\Property(ref="#/components/schemas/AnsPaging")
     */
    public AnsPaging $paging;

    public function setItems(array $input)
    {
        $this->items = collect();

        foreach ($input as $key => $val) {
            $this->items->push(new ItemSearch($val));
        }
    }
}
