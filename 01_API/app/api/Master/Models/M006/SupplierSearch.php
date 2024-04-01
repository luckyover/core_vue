<?php

namespace App\api\Master\Models\M006;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M006SupplierSearch",
 *      description="Data supplier will show in table"
 * )
 */
class SupplierSearch extends AnsModel
{
    /**
     * @OA\Property(example="1")
     */
    public ?int $supplier_cd = 0;

    /**
     * @OA\Property(example="仕入先区分")
     */
    public ?string $supplier_div_nm = '';

    /**
     * @OA\Property(example="カナ")
     */
    public ?string $supplier_kn_nm = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $supplier_ab_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_tel = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_mail_address = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_class_div1_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_class_div2_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_class_div3_nm = '';
}
