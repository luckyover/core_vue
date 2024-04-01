<?php

namespace App\api\Master\Requests\M006;

use AnsRequest;
use App\api\Master\Models\M006\SearchCondition;

class SearchSupplierRequest extends AnsRequest
{
    public function makeCondition(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
