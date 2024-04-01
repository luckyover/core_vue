<?php

namespace App\api\Master\Requests\M101;

use AnsRequest;
use App\api\Master\Models\M101\SearchCondition;

class SearchItemRequest extends AnsRequest
{
    public function makeCondition(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
