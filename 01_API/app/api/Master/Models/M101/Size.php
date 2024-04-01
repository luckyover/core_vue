<?php

namespace App\api\Master\Models\M101;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M101Size",
 *      description="Data sizes of product"
 * )
 */
class Size extends AnsModel
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
     * @OA\Property(example="L")
     */
    public ?string $size_cd = '';

    /**
     * @OA\Property(example="0")
     */
    public ?int $discontinued_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $discontinued_display_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $sort_div;
}
