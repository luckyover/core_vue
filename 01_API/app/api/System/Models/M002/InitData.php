<?php

namespace App\api\System\Models\M002;

use AnsModel;
use App\Models\AnsLibrary;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M002InitData",
 *      description="Data need to init screen M002"
 * )
 */
class InitData extends AnsModel
{
    public function __construct()
    {
        $this->belong_department_div = collect(new AnsLibrary);
        $this->authority_div = collect(new AnsLibrary);
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $belong_department_div;

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/AnsLibrary")
     * )
     */
    public Collection $authority_div;

    public function setBelongDepartmentDiv(array $input)
    {
        $this->belong_department_div = collect();
        foreach ($input as $key => $val) {
            $this->belong_department_div->push(new AnsLibrary($val));
        }
    }

    public function setAuthorityDiv(array $input)
    {
        $this->authority_div = collect();
        foreach ($input as $key => $val) {
            $this->authority_div->push(new AnsLibrary($val));
        }
    }
}
