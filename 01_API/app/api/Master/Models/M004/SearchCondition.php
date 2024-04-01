<?php

namespace App\api\Master\Models\M004;

use AnsModel;
use App\Utility\Constants;

class SearchCondition extends AnsModel
{
    public ?int $inq_customer_cd = 0;

    public ?int $inq_billing_source_cd = 0;

    public ?string $inq_customer_nm = '';

    public ?string $inq_customer_kn_nm = '';

    public ?string $inq_customer_ab_nm = '';

    public ?string $inq_customer_tel = '';

    public ?int $inq_customer_class_div1 = 0;

    public ?int $inq_customer_class_div2 = 0;

    public ?int $inq_customer_class_div3 = 0;

    public ?int $inq_billing_closing_div = 0;

    public ?string $inq_sales_employee_cd = '';

    public ?int $page_size = Constants::DEFAULT_PAGE_SIZE;

    public ?int $page = 1;

    public ?string $sort_column = 'customer_cd';

    public ?string $sort_type = 'ASC';
}
