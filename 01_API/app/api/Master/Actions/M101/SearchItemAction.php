<?php

namespace App\api\Master\Actions\M101;

use App\api\Master\Models\M101\ListOfItem;
use App\api\Master\Models\M101\SearchCondition;
use App\Models\AnsPaging;
use App\Repositories\IItemRepository;

class SearchItemAction
{
    private IItemRepository $itemRepository;

    public function __construct(
        IItemRepository $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    public function handle(SearchCondition $condition): ListOfItem
    {
        $data = $this->itemRepository->search($condition);
        $result = new ListOfItem;
        $result->paging = new AnsPaging($data[1][0] ?? []);
        $result->setItems($data[0] ?? []);

        return $result;
    }
}
