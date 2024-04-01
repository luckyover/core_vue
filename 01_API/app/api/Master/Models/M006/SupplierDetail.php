<?php

namespace App\api\Master\Models\M006;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M006SupplierDetail",
 *      description="Data detail of supplier"
 * )
 */
class SupplierDetail extends AnsModel
{
    /**
     * @OA\Property(example=0)
     */
    public ?int $supplier_cd = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $supplier_div = 0;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $supplier_nm = '';

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
    public ?string $supplier_zip = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $supplier_address1 = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $supplier_address2 = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $supplier_address3 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_tel = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_fax = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $supplier_department_nm = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $supplier_manager_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $supplier_mail_address = '';

    /**
     * @OA\Property(example="0")
     */
    public ?int $supplier_class_div1 = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $supplier_class_div2 = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $supplier_class_div3 = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $supplier_closing_div = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $transfer_date1 = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $transfer_date2 = 0;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $remarks = '';
}
