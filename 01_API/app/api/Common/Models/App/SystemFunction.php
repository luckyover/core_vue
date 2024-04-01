<?php

namespace App\api\Common\Models\App;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="SystemFunction",
 *      description="List function of system and permission for current user"
 * )
 */
class SystemFunction extends AnsModel
{
    /**
     * @OA\Property(example="M002")
     */
    public ?string $prg_cd = '';

    /**
     * @OA\Property(example="/master/m002")
     */
    public ?string $prg_url = '';

    /**
     * @OA\Property(example="save")
     */
    public ?string $fnc_cd = '';

    /**
     * @OA\Property(example="保存")
     */
    public ?string $fnc_nm = '';

    /**
     * @OA\Property(example="1")
     */
    public ?bool $fnc_use_div = false;
}
