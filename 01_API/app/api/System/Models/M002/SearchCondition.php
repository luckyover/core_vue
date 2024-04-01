<?php

namespace App\api\System\Models\M002;

use AnsModel;
use App\Utility\Constants;

class SearchCondition extends AnsModel
{
    public ?string $inq_user_cd = '';

    public ?string $inq_user_nm = '';

    public ?string $inq_user_kn_nm = '';

    public ?string $inq_user_ab_nm = '';

    public ?string $inq_tel = '';

    public ?string $inq_fax = '';

    public ?string $inq_mailaddress = '';

    public ?int $inq_belong_department_div = 0;

    public ?int $page_size = Constants::DEFAULT_PAGE_SIZE;

    public ?int $page = 1;

    public ?string $sort_column = 'user_cd';

    public ?string $sort_type = 'ASC';
}
