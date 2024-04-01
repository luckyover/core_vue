<?php

namespace App\api\Master\Models\M006;

use AnsModel;
use App\Utility\Constants;

class SearchCondition extends AnsModel
{
    public ?int $inq_supplier_cd = 0;

    public ?int $inq_supplier_div = 0;

    public ?string $inq_supplier_nm = '';

    public ?string $inq_supplier_kn_nm = '';

    public ?string $inq_supplier_ab_nm = '';

    public ?string $inq_supplier_tel = '';

    public ?int $inq_supplier_class_div1 = 0;

    public ?int $inq_supplier_class_div2 = 0;

    public ?int $inq_supplier_class_div3 = 0;

    public ?int $page_size = Constants::DEFAULT_PAGE_SIZE;

    public ?int $page = 1;

    public ?string $sort_column = 'supplier_cd';

    public ?string $sort_type = 'ASC';
}
