<?php

namespace App\api\Common\Models\App;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="Menu",
 *      description="List menu enable to view"
 * )
 */
class Menu extends AnsModel
{
    /**
     * @OA\Property(example="M002")
     */
    public ?string $prg_cd = '';

    /**
     * @OA\Property(example="社員マスタ")
     */
    public ?string $prg_nm = '';

    /**
     * @OA\Property(example="/system/m002")
     */
    public ?string $prg_url = '';

    /**
     * @OA\Property(example="99")
     */
    public ?int $prg_group_div = 1;

    /**
     * @OA\Property(example="システム")
     */
    public ?string $prg_group_nm = '';
}
