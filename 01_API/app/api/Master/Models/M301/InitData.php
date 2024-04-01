<?php

namespace App\api\Master\Models\M301;

use AnsModel;
use App\Models\AnsLibrary;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M301InitData",
 *      description="Data need to init screen M301"
 * )
 */
class InitData extends AnsModel
{
    public function __construct()
    {
        $this->category_div = collect(new AnsLibrary);
        $this->material_div = collect(new AnsLibrary);
        $this->processing_location_div = collect(new AnsLibrary);
        $this->number_of_color_div = collect(new AnsLibrary);
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
    public Collection $processing_location_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $number_of_color_div;

    public function setLib(array $input, int $type)
    {
        if ($type === 1) {
            $this->category_div = collect();
            foreach ($input as $key => $val) {
                $this->category_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 2) {
            $this->material_div = collect();
            foreach ($input as $key => $val) {
                $this->material_div->push(new AnsLibrary($val));
            }
        }

        if ($type === 3) {
            $this->processing_location_div = collect();
            foreach ($input as $key => $val) {
                $this->processing_location_div->push(new AnsLibrary($val));
            }
        }

        if ($type === 4) {
            $this->number_of_color_div = collect();
            foreach ($input as $key => $val) {
                $this->number_of_color_div->push(new AnsLibrary($val));
            }
        }
    }
}
