<?php

namespace App\api\Master\Requests\M101;

use AnsRequest;
use App\api\Master\Models\M101\Item;

class DeleteItemRequest extends AnsRequest
{
    public function makeKeyRefer(): Item
    {
        return new Item($this->all());
    }
}
