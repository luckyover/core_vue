<?php

namespace App\Models;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="AnsSuggestSearch",
 *      description="Data for suggest search"
 * )
 */
class AnsSuggestSearch extends AnsModel
{
    /**
     * @OA\Property(example="53")
     */
    public ?string $code = '';

    /**
     * @OA\Property(example="仕入先名")
     */
    public ?string $name = '';

    /**
     * @OA\Property(example="1")
     */
    public ?string $subTitle = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $value1 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $value2 = '';

    /**
     * @OA\Property(example="")
     */
    public ?string $value3 = '';
}
