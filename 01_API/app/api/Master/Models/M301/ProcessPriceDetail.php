<?php

namespace App\api\Master\Models\M301;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M301ProcessPriceDetail",
 *      description="Data detail of processPrice detail"
 * )
 */
class ProcessPriceDetail extends AnsModel
{
    /**
     * @OA\Property(example="-1")
     */
    public ?int $idx = -1;

    /**
     * @OA\Property(example="KZT0001")
     */
    public ?string $item_cd = '';

    /**
     * @OA\Property(example="'プリント代")
     */
    public ?string $item_nm = '';

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
    public ?int $number_sheet_fr = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $number_sheet_to = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $color_div = 0;

    /**
     * @OA\Property(example="686")
     */
    public ?int $sales_amt = 0;
}
