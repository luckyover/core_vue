<?php

namespace App\api\System\Models\M002;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M002UserSearch",
 *      description="Data of user to show in list"
 * )
 */
class UserSearch extends AnsModel
{
    /**
     * @OA\Property(example="809")
     */
    public ?string $user_cd;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $user_nm;

    /**
     * @OA\Property(example="ユーザーカナ")
     */
    public ?string $user_kn_nm;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $user_ab_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $tel;

    /**
     * @OA\Property(example="")
     */
    public ?string $fax;

    /**
     * @OA\Property(example="")
     */
    public ?string $mailaddress;

    /**
     * @OA\Property(example="")
     */
    public ?string $belong_department_div_nm = '';
}
