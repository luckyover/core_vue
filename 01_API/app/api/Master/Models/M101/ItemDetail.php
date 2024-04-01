<?php

namespace App\api\Master\Models\M101;

use AnsModel;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M101ItemDetail",
 *      description="Data detail for save product"
 * )
 */
class ItemDetail extends AnsModel
{
    public function __construct($data)
    {
        $this->sizes = collect();
        foreach ($data['sizes'] as $key => $val) {
            $this->sizes->push(new Size($val));
        }
        unset($data['sizes']);
        parent::__construct($data);
    }

    /**
     * @OA\Property(example="OE1116")
     */
    public ?string $item_cd = '';

    /**
     * @OA\Property(example="01")
     */
    public ?string $color_cd = '';

    /**
     * @OA\Property(example="マックスウェイトTシャツ")
     */
    public ?string $item_nm = '';

    /**
     * @OA\Property(example="マックスウェイトTシャツ")
     */
    public ?string $item_kn_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $item_ab_nm = '';

    /**
     * @OA\Property(example="ホワイト")
     */
    public ?string $color_nm = '';

    /**
     * @OA\Property(example="ホワイト")
     */
    public ?string $color_kn_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $color_ab_nm = '';

    /**
     * @OA\Property(example="0")
     */
    public ?int $item_class_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $process_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $category_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $material_div = 0;

    /**
     * @OA\Property(example="1")
     */
    public ?int $supplier_cd = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_item_cd = '';

    /**
     * @OA\Property(example="0")
     */
    public ?int $tax_div = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $remarks = '';

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M101Size")
     * )
     */
    public Collection $sizes;
}
