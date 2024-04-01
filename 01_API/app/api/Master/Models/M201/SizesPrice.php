<?php

namespace App\api\Master\Models\M201;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M201SizesPrice",
 *      description="Data sizes price of product"
 * )
 */
class SizesPrice extends AnsModel
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
    public ?string $item_nm = '';

    /**
     * @OA\Property(example="L")
     */
    public ?string $size_cd = '';

    /**
     * @OA\Property(example="0")
     */
    public ?int $price_list = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $retail_upr = 0;

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
