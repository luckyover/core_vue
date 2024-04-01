<?php

namespace App\api\Master\Models\M302;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M302ProcessCost",
 *      description="Data sizes of product"
 * )
 */
class ProcessCost extends AnsModel
{
    /**
     * @OA\Property(example="50")
     */
    public ?string $supplier_cd = '';

    /**
     * @OA\Property(example="仕入先名")
     */
    public ?string $supplier_nm = '';

    /**
     * @OA\Property(example="KZT0003")
     */
    public ?string $item_cd = '';

    /**
     * @OA\Property(example="'プリント代")
     */
    public ?string $item_nm = '';

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
