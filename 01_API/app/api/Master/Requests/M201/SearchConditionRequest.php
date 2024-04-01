<?php

namespace App\api\Master\Requests\M201;

use AnsRequest;
use App\api\Master\Models\M201\SearchCondition;

class SearchConditionRequest extends AnsRequest
{
    public function makeKeyRefer(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
