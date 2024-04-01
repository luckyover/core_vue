<?php

namespace App\api\System\Models\M002;

use AnsModel;
use App\Models\AnsPaging;
use Illuminate\Support\Collection;

/**
 * @OA\Schema(
 *      schema="M002ListOfUsers",
 *      description="Data have list of users and data for paging"
 * )
 */
class ListOfUsers extends AnsModel
{
    public function __construct()
    {
        $this->users = collect();
    }

    /**
     * @OA\Property(
     *      type="array",
     *
     *      @OA\Items(ref="#/components/schemas/M002UserSearch")
     * )
     */
    public Collection $users;

    /**
     * @OA\Property(ref="#/components/schemas/AnsPaging")
     */
    public AnsPaging $paging;

    public function setUsers(array $input)
    {
        $this->users = collect();

        foreach ($input as $key => $val) {
            $this->users->push(new UserSearch($val));
        }
    }
}
