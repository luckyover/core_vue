<?php

namespace App\api\Master\Models\M101;

use AnsModel;
use App\Utility\Constants;

class SearchCondition extends AnsModel
{
    public ?string $inq_item_cd = '';

    public ?string $inq_item_nm = '';

    public ?string $inq_color_cd = '';

    public ?string $inq_color_nm = '';

    public ?int $inq_item_class_div = 0;

    public ?int $inq_process_div = 0;

    public ?int $inq_category_div = 0;

    public ?int $inq_supplier_cd = 0;

    public ?int $page_size = Constants::DEFAULT_PAGE_SIZE;

    public ?int $page = 1;

    public ?string $sort_column = 'item_cd';

    public ?string $sort_type = 'ASC';

    public ?bool $remove_process = false;
}
