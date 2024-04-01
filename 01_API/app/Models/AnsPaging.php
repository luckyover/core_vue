<?php

namespace App\Models;

use AnsModel;
use App\Utility\Constants;

/**
 * @OA\Schema(
 *      schema="AnsPaging",
 *      description="Data for paging"
 * )
 */
class AnsPaging extends AnsModel
{
    /**
     * @OA\Property(example="50")
     */
    public int $pageSize = Constants::DEFAULT_PAGE_SIZE;

    /**
     * @OA\Property(example="1")
     */
    public int $page = 1;

    /**
     * @OA\Property(example="100")
     */
    public int $totalRecord = 0;
}
