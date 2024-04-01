<?php

namespace App\Models;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="AnsLibrary",
 *      description="Data library for combobox"
 * )
 */
class AnsLibrary extends AnsModel
{
    /**
     * @OA\Property(example="belong_department_div")
     */
    public ?string $name_div;

    /**
     * @OA\Property(example="1")
     */
    public ?int $name_cd = 0;

    /**
     * @OA\Property(example="営業")
     */
    public ?string $name;

    /**
     * @OA\Property(example="")
     */
    public ?string $kn_name;

    /**
     * @OA\Property(example="営業")
     */
    public ?string $ab_name;

    /**
     * @OA\Property(example="")
     */
    public ?string $char_remakrs_ex1;

    /**
     * @OA\Property(example="")
     */
    public ?string $char_remakrs1;

    /**
     * @OA\Property(example="")
     */
    public ?string $char_remakrs_ex2;

    /**
     * @OA\Property(example="")
     */
    public ?string $char_remakrs2;

    /**
     * @OA\Property(example="0")
     */
    public ?int $num_remakrs_ex1;

    /**
     * @OA\Property(example="0")
     */
    public ?int $num_remakrs1;

    /**
     * @OA\Property(example="0")
     */
    public ?int $num_remakrs_ex2;

    /**
     * @OA\Property(example="0")
     */
    public ?int $num_remakrs2;

    /**
     * @OA\Property(example="0")
     */
    public ?int $default_flg = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $sort = 0;
}
