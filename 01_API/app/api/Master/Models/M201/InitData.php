<?php

namespace App\api\Master\Models\M201;

use AnsModel;
use App\Models\AnsLibrary;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M201InitData",
 *      description="Data need to init screen M201"
 * )
 */
class InitData extends AnsModel
{
    public function __construct()
    {
        $this->price_list = collect(new AnsLibrary);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $price_list;

    public function setLib(array $input, int $type)
    {
        if ($type === 2) {
            $this->price_list = collect();
            foreach ($input as $key => $val) {
                $this->price_list->push(new AnsLibrary($val));
            }
        }
    }
}
