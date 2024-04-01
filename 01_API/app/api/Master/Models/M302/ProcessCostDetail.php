<?php

namespace App\api\Master\Models\M302;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M302ProcessCostDetail",
 *      description="Data cost of product"
 * )
 */
class ProcessCostDetail extends AnsModel
{
    /**
     * @OA\Property(example="-1")
     */
    public ?int $idx = -1;

    /**
     * @OA\Property(example="50")
     */
    public ?string $supplier_cd = '';

    /**
     * @OA\Property(example="KZT0003")
     */
    public ?string $item_cd = '';

    /**
     * @OA\Property(example="1")
     */
    public ?string $number_sheet_fr = '';

    /**
     * @OA\Property(example="10")
     */
    public ?string $number_sheet_to = '';

    /**
     * @OA\Property(example="0")
     */
    public ?int $category_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $material_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $processing_place_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $color_div = 0;

    /**
     * @OA\Property(example="330")
     */
    public ?string $sales_amt = '';
}
