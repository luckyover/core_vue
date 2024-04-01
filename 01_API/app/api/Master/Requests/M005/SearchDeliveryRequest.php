<?php

namespace App\api\Master\Requests\M005;

use AnsRequest;
use App\api\Master\Models\M005\SearchCondition;

class SearchDeliveryRequest extends AnsRequest
{
    public function makeCondition(): SearchCondition
    {
        return new SearchCondition($this->all());
    }
}
