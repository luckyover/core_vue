<?php

namespace App\api\Master\Models\M101;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M101Item",
 *      description="Data detail of product"
 * )
 */
class Item extends AnsModel
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
    public ?string $supplier_item_cd;

    /**
     * @OA\Property(example="0")
     */
    public ?int $tax_div = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $remarks;

    /**
     * @OA\Property(example="仕入先名")
     */
    public ?string $supplier_nm;

    /**
     * @OA\Property(example="809")
     */
    public ?string $cre_user_cd;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $cre_user_nm;

    /**
     * @OA\Property(example="2024/02/26 08:30")
     */
    public ?string $cre_tm;

    /**
     * @OA\Property(example="")
     */
    public ?string $upd_user_cd;

    /**
     * @OA\Property(example="")
     */
    public ?string $upd_user_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $upd_tm;
}
