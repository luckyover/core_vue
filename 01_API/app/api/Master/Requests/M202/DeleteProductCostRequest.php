<?php

namespace App\api\Master\Requests\M202;

use AnsRequest;
use App\api\Master\Models\M202\PostDelProductCost;

class DeleteProductCostRequest extends AnsRequest
{
    public function makeCondition(): PostDelProductCost
    {
        return new PostDelProductCost($this->all());
    }
}
