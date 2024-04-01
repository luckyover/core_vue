<?php

namespace App\api\Master\Models\M004;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M004CustomerDetail",
 *      description="Data detail of customer"
 * )
 */
class CustomerDetail extends AnsModel
{
    /**
     * @OA\Property(example="901")
     */
    public ?int $customer_cd = 0;

    /**
     * @OA\Property(example="1")
     */
    public ?int $billing_source_cd = 1;

    /**
     * @OA\Property(example="Hainn")
     */
    public ?string $customer_nm = '';

    /**
     * @OA\Property(example="abc")
     */
    public ?string $customer_kn_nm = '';

    /**
     * @OA\Property(example="abc")
     */
    public ?string $customer_ab_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_zip = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_address1 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_address2 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_address3 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_tel = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_fax = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_department_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $customer_manager_nm = '';

    /**
     * @OA\Property(example="abc123@gmail.com")
     */
    public ?string $customer_mail_address = '';

    /**
     * @OA\Property(example="1")
     */
    public ?int $customer_class_div1 = 0;

    /**
     * @OA\Property(example="1")
     */
    public ?int $customer_class_div2 = 0;

    /**
     * @OA\Property(example="1")
     */
    public ?int $customer_class_div3 = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_zip = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_address1 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_address2 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_address3 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_tel = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_fax = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_department_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_manager_nm = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $billing_mail_address = '';

    /**
     * @OA\Property(example="1")
     */
    public ?int $billing_closing_div = 0;

    /**
     * @OA\Property(example="1")
     */
    public ?int $transfer_date1 = 0;

    /**
     * @OA\Property(example="1")
     */
    public ?int $transfer_date2 = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $sales_employee_cd = '';

    /**
     * @OA\Property(example="1")
     */
    public ?int $price_list = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $reason_for_closure = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $remarks = '';
}
