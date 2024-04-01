<?php

namespace App\api\Master\Models\M202;

use AnsModel;

class SearchCondition extends AnsModel
{
    public ?string $item_cd = '';

    public ?string $color_cd = '';

    public ?string $item_nm = '';

    public ?string $size_cd = '';

    public ?string $supplier_cd = '';

    public ?string $supplier_nm = '';
}
