<?php

namespace App\api\Master\Models\M101;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M101Data",
 *      description="Data detail for screen M101"
 * )
 */
class M101Data extends AnsModel
{
    public function __construct()
    {
        $this->sizes = collect(new Size);
        $this->item = new Item;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M101Item")
     */
    public Item $item;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M101Size")
     * )
     */
    public Collection $sizes;

    public function setSizes(array $sizes)
    {
        $this->sizes = collect();
        foreach ($sizes as $key => $val) {
            $this->sizes->push(new Size($val));
        }
    }
}
