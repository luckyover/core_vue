<?php

namespace App\api\Master\Models\M201;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M201SizesPriceDetail",
 *      description="Data detail sizes price of product"
 * )
 */
class SizesPriceDetail extends AnsModel
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
}
