<?php

namespace App\api\Master\Actions\M101;

use App\api\Master\Models\M101\Item;
use App\api\Master\Models\M101\SearchCondition;
use App\Repositories\IItemRepository;

class ReferNameItemAction
{
    private IItemRepository $itemRepository;

    public function __construct(
        IItemRepository $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    public function handle(SearchCondition $params): Item
    {
        return new Item($this->itemRepository->refer($params));
    }
}
