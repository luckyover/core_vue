<?php

namespace App\api\Master\Models\M101;

use AnsModel;
use App\Models\AnsLibrary;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M101InitData",
 *      description="Data need to init screen M101"
 * )
 */
class InitData extends AnsModel
{
    public function __construct()
    {
        $this->item_class_div = collect(new AnsLibrary);
        $this->process_div = collect(new AnsLibrary);
        $this->category_div = collect(new AnsLibrary);
        $this->material_div = collect(new AnsLibrary);
        $this->tax_div = collect(new AnsLibrary);
        $this->discontinued_div = collect(new AnsLibrary);
        $this->discontinued_display_div = collect(new AnsLibrary);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $item_class_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $process_div;

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
    public Collection $tax_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $discontinued_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $discontinued_display_div;

    public function setLib(array $input, int $type)
    {
        if ($type === 2) {
            $this->item_class_div = collect();
            foreach ($input as $key => $val) {
                $this->item_class_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 3) {
            $this->process_div = collect();
            foreach ($input as $key => $val) {
                $this->process_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 4) {
            $this->category_div = collect();
            foreach ($input as $key => $val) {
                $this->category_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 5) {
            $this->material_div = collect();
            foreach ($input as $key => $val) {
                $this->material_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 6) {
            $this->tax_div = collect();
            foreach ($input as $key => $val) {
                $this->tax_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 7) {
            $this->discontinued_div = collect();
            foreach ($input as $key => $val) {
                $this->discontinued_div->push(new AnsLibrary($val));
            }
        }
        if ($type === 8) {
            $this->discontinued_display_div = collect();
            foreach ($input as $key => $val) {
                $this->discontinued_display_div->push(new AnsLibrary($val));
            }
        }
    }
}
