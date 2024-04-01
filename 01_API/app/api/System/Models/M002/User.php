<?php

namespace App\api\System\Models\M002;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="M002User",
 *      description="Data detail of user"
 * )
 */
class User extends AnsModel
{
    /**
     * @OA\Property(example="809")
     */
    public ?string $user_cd;

    /**
     * @OA\Property(example="123")
     */
    public ?string $password;

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
     * @OA\Property(example="1")
     */
    public ?int $belong_department_div = 0;

    /**
     * @OA\Property(example="1")
     */
    public ?int $authority_div = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $remarks;

    /**
     * @OA\Property(example="809")
     */
    public ?string $cre_user_cd;

    /**
     * @OA\Property(example="テスト太郎")
     */
    public ?string $cre_user_nm;

    /**
     * @OA\Property(example="2024/02/26 08:30")
     */
    public ?string $cre_tm;

    /**
     * @OA\Property(example="")
     */
    public ?string $upd_user_cd;

    /**
     * @OA\Property(example="")
     */
    public ?string $upd_user_nm;

    /**
     * @OA\Property(example="")
     */
    public ?string $upd_tm;
}
