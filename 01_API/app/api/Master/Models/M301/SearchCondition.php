<?php

namespace App\api\Master\Models\M301;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M301SearchCondition",
 *      description="Data detail for search process price"
 * )
 */
class SearchCondition extends AnsModel
{
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
    public ?int $processing_location_div = 0;
}
