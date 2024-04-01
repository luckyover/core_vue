<?php

namespace App\api\Master\Requests\M302;

use AnsRequest;
use App\api\Master\Models\M302\SearchCondition;

class SearchProcessCostRequest extends AnsRequest
{
    public function makeCondition(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
