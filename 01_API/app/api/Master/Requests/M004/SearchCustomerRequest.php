<?php

namespace App\api\Master\Requests\M004;

use AnsRequest;
use App\api\Master\Models\M004\SearchCondition;

class SearchCustomerRequest extends AnsRequest
{
    public function makeCondition(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
