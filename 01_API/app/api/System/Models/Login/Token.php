<?php

namespace App\api\System\Models\Login;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="JwtToken",
 *      description="Data have token information of user after login"
 * )
 */
class Token extends AnsModel
{
    /**
     * @OA\Property(example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODg4OFwvYXBpXC92MVwvbG9naW4iLCJpYXQiOjE2Mzg3MjQzNjUsImV4cCI6MTYzODgxMDc2NSwibmJmIjoxNjM4NzI0MzY1LCJqdGkiOiJXdWJYaWZKQzBRNmtlUGFsIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.JMwK89gruD9u2lOxxmWG7bliJhIMNQAvH3D9XLx3d7k")
     */
    public ?string $token;

    /**
     * @OA\Property(example="86400")
     */
    public int $timeout;

    /**
     * @OA\Property(example="/")
     */
    public ?string $urlBefore;

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
