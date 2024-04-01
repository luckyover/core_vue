<?php

namespace App\api\Master\Models\M004;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M004CustomerSearch",
 *      description="Data of customer to show in table"
 * )
 */
class CustomerSearch extends AnsModel
{
    /**
     * @OA\Property(example="901")
     */
    public ?int $customer_cd = 0;

    /**
     * @OA\Property(example="株式会社スパークル")
     */
    public ?string $billing_source_nm = '';

    /**
     * @OA\Property(example="Hainn")
     */
    public ?string $customer_nm;

    /**
     * @OA\Property(example="カナ")
     */
    public ?string $customer_kn_nm;

    /**
     * @OA\Property(example="abc")
     */
    public ?string $customer_ab_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_tel;

    /**
     * @OA\Property(example="abc123@gmail.com")
     */
    public ?string $customer_mail_address;

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_class_div1_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_class_div2_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_class_div3_nm = '';

    /**
     * @OA\Property(example="1")
     */
    public ?string $billing_closing_div_nm = '';

    /**
     * @OA\Property(example="1")
     */
    public ?string $transfer_date1_nm = '';

    /**
     * @OA\Property(example="1")
     */
    public ?string $transfer_date2_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $sales_employee_nm = '';
}
