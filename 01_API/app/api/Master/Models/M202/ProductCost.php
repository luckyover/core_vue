<?php

namespace App\api\Master\Models\M202;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M202ProductCost",
 *      description="Data detail of product cost"
 * )
 */
class ProductCost extends AnsModel
{
    /**
     * @OA\Property(example="1")
     */
    public ?string $item_cd = '';

    /**
     * @OA\Property(example="OE1116")
     */
    public ?string $color_cd = '';

    /**
     * @OA\Property(example="OE1116")
     */
    public ?string $size_cd = '';

    /**
     * @OA\Property(example="OE1116")
     */
    public ?int $supplier_cd;

    /**
     * @OA\Property(example="OE1116")
     */
    public ?string $retail_upr;

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
