<?php

namespace App\api\Master\Models\M301;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M301ProcessPrice",
 *      description="Data detail of ProcessPrice"
 * )
 */
class ProcessPrice extends AnsModel
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
     * @OA\Property(example="0")
     */
    public ?int $sales_amt = 0;

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
