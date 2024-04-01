<?php

namespace App\api\System\Resources\M002;

use AnsResponse;
use App\api\System\Models\M002\ListOfUsers;

/**
 * @OA\Schema(schema="M002ListOfUsersResource")
 */
class ListOfUsersResource extends AnsResponse
{
    public function __construct(ListOfUsers $data)
    {
        $this->data = $data;
    }

    /**
     * @OA\Property(ref="#/components/schemas/M002ListOfUsers")
     */
    public ListOfUsers $data;
}
