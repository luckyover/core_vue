<?php

namespace App\Models;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="ERRTABLE",
 *      description="Data error when processing data"
 * )
 */
class TableError extends AnsModel
{
    /**
     * @OA\Property(example="1")
     */
    public ?int $id = 0;

    /**
     * @OA\Property(example="E001")
     */
    public ?string $message_cd = '';

    /**
     * @OA\Property(example="user_cd")
     */
    public ?string $item;

    /**
     * @OA\Property(example="0")
     */
    public ?int $order_by = 0;

    /**
     * @OA\Property(example="0")
     */
    public ?int $value1 = 0;

    /**
     * @OA\Property(example="")
     */
    public ?string $value2;

    /**
     * @OA\Property(example="")
     */
    public ?string $remark;
}
