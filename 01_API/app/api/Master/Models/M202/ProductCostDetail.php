<?php

namespace App\api\Master\Models\M202;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M202ProductCostDetail",
 *      description="Data detail for save product cost"
 * )
 */
class ProductCostDetail extends AnsModel
{
    /**
     * @OA\Property(example="-1")
     */
    public ?int $idx = -1;

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
     * @OA\Property(example="0")
     */
    public ?int $supplier_cd;

    /**
     * @OA\Property(example="OE1116")
     */
    public ?string $retail_upr = '';
}
