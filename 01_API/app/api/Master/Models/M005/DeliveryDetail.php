<?php

namespace App\api\Master\Models\M005;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M005DeliveryDetail",
 *      description="Data detail of delivery"
 * )
 */
class DeliveryDetail extends AnsModel
{
    /**
     * @OA\Property(example="1")
     */
    public ?int $delivery_cd = 0;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_nm = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_kn_nm = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_ab_nm = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_zip = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_address1 = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_address2 = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_address3 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $delivery_tel = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $delivery_fax = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_department_nm = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_manager_nm = '';

    /**
     * @OA\Property(example="abc@gmail.com")
     */
    public ?string $delivery_mail_address = '';

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $remarks = '';
}
