<?php

namespace App\api\Master\Models\M005;

use AnsModel;
use App\Utility\Constants;

class SearchCondition extends AnsModel
{
    public ?int $inq_delivery_cd = 0;

    public ?string $inq_delivery_nm = '';

    public ?string $inq_delivery_kn_nm = '';

    public ?string $inq_delivery_ab_nm = '';

    public ?string $inq_delivery_tel = '';

    public ?int $page_size = Constants::DEFAULT_PAGE_SIZE;

    public ?int $page = 1;

    public ?string $sort_column = 'delivery_cd';

    public ?string $sort_type = 'ASC';
}
