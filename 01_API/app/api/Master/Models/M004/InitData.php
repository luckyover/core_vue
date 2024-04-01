<?php

namespace App\api\Master\Models\M004;

use AnsModel;
use API\Master\Models\M004\CompanyCombobox;
use App\Models\AnsLibrary;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M004InitData",
 *      description="Data need to init screen M004"
 * )
 */
class InitData extends AnsModel
{
    public function __construct()
    {
        $this->billing_source_cd = collect(new CompanyCombobox);
        $this->customer_class_div1 = collect(new AnsLibrary);
        $this->customer_class_div2 = collect(new AnsLibrary);
        $this->customer_class_div3 = collect(new AnsLibrary);
        $this->billing_closing_div = collect(new AnsLibrary);
        $this->transfer_date1 = collect(new AnsLibrary);
        $this->transfer_date2 = collect(new AnsLibrary);
        $this->price_list = collect(new AnsLibrary);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M004CompanyCombobox")
     * )
     */
    public Collection $billing_source_cd;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $customer_class_div1;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $customer_class_div2;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $customer_class_div3;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $billing_closing_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $transfer_date1;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $transfer_date2;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $price_list;

    public function setBillingSourceCd(array $input)
    {
        $this->billing_source_cd = collect();

        foreach ($input as $key => $val) {
            $this->billing_source_cd->push(new CompanyCombobox($val));
        }
    }

    public function setCustomerClassDiv1(array $input)
    {
        $this->customer_class_div1 = collect();
        foreach ($input as $key => $val) {
            $this->customer_class_div1->push(new AnsLibrary($val));
        }
    }

    public function setCustomerClassDiv2(array $input)
    {
        $this->customer_class_div2 = collect();
        foreach ($input as $key => $val) {
            $this->customer_class_div2->push(new AnsLibrary($val));
        }
    }

    public function setCustomerClassDiv3(array $input)
    {
        $this->customer_class_div3 = collect();
        foreach ($input as $key => $val) {
            $this->customer_class_div3->push(new AnsLibrary($val));
        }
    }

    public function setBillingClosingDiv(array $input)
    {
        $this->billing_closing_div = collect();
        foreach ($input as $key => $val) {
            $this->billing_closing_div->push(new AnsLibrary($val));
        }
    }

    public function setTransferDate1(array $input)
    {
        $this->transfer_date1 = collect();
        foreach ($input as $key => $val) {
            $this->transfer_date1->push(new AnsLibrary($val));
        }
    }

    public function setTransferDate2(array $input)
    {
        $this->transfer_date2 = collect();
        foreach ($input as $key => $val) {
            $this->transfer_date2->push(new AnsLibrary($val));
        }
    }

    public function setPriceList(array $input)
    {
        $this->price_list = collect();
        foreach ($input as $key => $val) {
            $this->price_list->push(new AnsLibrary($val));
        }
    }
}
