<?php

namespace App\api\Master\Models\M302;

use AnsModel;
use App\Models\AnsLibrary;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M302InitData",
 *      description="Data need to init screen M302"
 * )
 */
class InitData extends AnsModel
{
    public function __construct()
    {
        $this->category_div = collect(new AnsLibrary);
        $this->material_div = collect(new AnsLibrary);
        $this->processing_place_div = collect(new AnsLibrary);
        $this->color_div = collect(new AnsLibrary);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $category_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $material_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $processing_place_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $color_div;

    public function setLib(array $input, int $type)
    {
        if ($type === 2) {
            $this->category_div = collect();
            foreach ($input as $key => $val) {
                $this->category_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 3) {
            $this->material_div = collect();
            foreach ($input as $key => $val) {
                $this->material_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 4) {
            $this->processing_place_div = collect();
            foreach ($input as $key => $val) {
                $this->processing_place_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 5) {
            $this->color_div = collect();
            foreach ($input as $key => $val) {
                $this->color_div->push(new AnsLibrary($val));
            }
        }
    }
}
