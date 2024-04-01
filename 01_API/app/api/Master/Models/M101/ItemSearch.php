<?php

namespace App\api\Master\Models\M101;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M101ItemSearch",
 *      description="Data product show in list"
 * )
 */
class ItemSearch extends AnsModel
{
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
    public ?string $item_nm;

    /**
     * @OA\Property(example="マックスウェイトTシャツ")
     */
    public ?string $item_kn_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $item_ab_nm;

    /**
     * @OA\Property(example="ホワイト")
     */
    public ?string $color_nm;

    /**
     * @OA\Property(example="ホワイト")
     */
    public ?string $color_kn_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $color_ab_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $item_class_div_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $process_div_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $category_div_nm;

    /**
     * @OA\Property(example="1")
     */
    public ?string $supplier_cd;

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier__nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_item_cd;
}
