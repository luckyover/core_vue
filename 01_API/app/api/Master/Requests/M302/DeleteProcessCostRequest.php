<?php

namespace App\api\Master\Requests\M302;

use AnsRequest;
use App\api\Master\Models\M302\DeleteProcessCost;

class DeleteProcessCostRequest extends AnsRequest
{
    public function makeData(): DeleteProcessCost
    {
        return new DeleteProcessCost($this->all());
    }
}
