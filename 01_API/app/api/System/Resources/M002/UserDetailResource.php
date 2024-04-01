<?php

namespace App\api\System\Resources\M002;

use AnsResponse;
use App\api\System\Models\M002\User;

/**
 * @OA\Schema(schema="M002UserDetailResource")
 */
class UserDetailResource extends AnsResponse
{
    public function __construct(User $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M002User")
     */
    public User $data;
}
