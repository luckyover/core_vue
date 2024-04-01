<?php

namespace App\api\Master\Models\M005;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M005DeliverySearch",
 *      description="Data detail of delivery"
 * )
 */
class DeliverySearch extends AnsModel
{
    /**
     * @OA\Property(example="0")
     */
    public ?int $delivery_cd;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_nm;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_kn_nm;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_ab_nm;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_zip;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_address1;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_address2;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_address3;

    /**
     * @OA\Property(example="")
     */
    public ?string $delivery_tel;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_department_nm;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $delivery_manager_nm;

    /**
     * @OA\Property(example="abc@gmail.com")
     */
    public ?string $delivery_mail_address;
}
