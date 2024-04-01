<?php

namespace App\api\Common\Models\App;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="Profile",
 *      description="Information of current user"
 * )
 */
class Profile extends AnsModel
{
    /**
     * @OA\Property(example="809")
     */
    public ?string $loginid;

    /**
     * @OA\Property(example="809")
     */
    public ?string $user_cd;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $user_nm;

    /**
     * @OA\Property(example="テスト太郎")
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
     * @OA\Property(example="1")
     */
    public int $belong_department_div = 0;

    /**
     * @OA\Property(example="営業")
     */
    public ?string $belong_department_nm;

    /**
     * @OA\Property(example="1")
     */
    public int $authority_div = 0;

    /**
     * @OA\Property(example="システム管理者")
     */
    public ?string $authority_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $remarks;
}
