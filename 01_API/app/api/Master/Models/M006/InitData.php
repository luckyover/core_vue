<?php

namespace App\api\Master\Models\M006;

use AnsModel;
use App\Models\AnsLibrary;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M006InitData",
 *      description="Data need to init screen M006"
 * )
 */
class InitData extends AnsModel
{
    public function __construct()
    {
        $this->supplier_div = collect(new AnsLibrary);
        $this->supplier_class_div1 = collect(new AnsLibrary);
        $this->supplier_class_div2 = collect(new AnsLibrary);
        $this->supplier_class_div3 = collect(new AnsLibrary);
        $this->supplier_closing_div = collect(new AnsLibrary);
        $this->transfer_date1 = collect(new AnsLibrary);
        $this->transfer_date2 = collect(new AnsLibrary);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $supplier_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $supplier_class_div1;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $supplier_class_div2;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $supplier_class_div3;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $supplier_closing_div;

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

    public function setSupplierDiv(array $input)
    {
        $this->supplier_div = collect();

        foreach ($input as $key => $val) {
            $this->supplier_div->push(new AnsLibrary($val));
        }
    }

    public function setSupplierClassDiv1(array $input)
    {
        $this->supplier_class_div1 = collect();

        foreach ($input as $key => $val) {
            $this->supplier_class_div1->push(new AnsLibrary($val));
        }
    }

    public function setSupplierClassDiv2(array $input)
    {
        $this->supplier_class_div2 = collect();
        foreach ($input as $key => $val) {
            $this->supplier_class_div2->push(new AnsLibrary($val));
        }
    }

    public function setSupplierClassDiv3(array $input)
    {
        $this->supplier_class_div3 = collect();
        foreach ($input as $key => $val) {
            $this->supplier_class_div3->push(new AnsLibrary($val));
        }
    }

    public function setSupplierClosingDiv(array $input)
    {
        $this->supplier_closing_div = collect();
        foreach ($input as $key => $val) {
            $this->supplier_closing_div->push(new AnsLibrary($val));
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
}
