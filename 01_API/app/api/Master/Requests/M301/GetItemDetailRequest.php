<?php

namespace App\api\Master\Requests\M301;

use AnsRequest;
use App\api\Master\Models\M301\Item;

class GetItemDetailRequest extends AnsRequest
{
    public function makeKeyRefer(): Item
    {
        return new Item($this->all());
    }
}
