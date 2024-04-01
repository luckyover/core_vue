<?php

namespace App\api\Common\Models\App;

use AnsModel;

/**
 * @OA\Schema(
 *      schema="ErrorMessage",
 *      description="List message to notify in screen"
 * )
 */
class ErrorMessage extends AnsModel
{
    /**
     * @OA\Property(example="E001")
     */
    public ?string $message_cd = '';

    /**
     * @OA\Property(example="1")
     */
    public ?string $type = '1';

    /**
     * @OA\Property(example="エラー")
     */
    public ?string $message_nm = '';

    /**
     * @OA\Property(example="必須項目。")
     */
    public ?string $message = '';
}
