<?php

namespace App\api\Master\Requests\M202;

use AnsRequest;
use App\api\Master\Models\M202\SearchCondition;

class SearchProductCostRequest extends AnsRequest
{
    public function makeCondition(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
