<?php

namespace App\api\Master\Models\M302;

use AnsModel;

class SearchCondition extends AnsModel
{
    public ?string $supplier_cd = '';

    public ?string $supplier_nm = '';

    public ?string $item_cd = '';

    public ?string $item_nm = '';

    public ?int $category_div = 0;

    public ?int $material_div = 0;

    public ?int $processing_place_div = 0;
}
