<?php

namespace App\api\Master\Actions\M101;

use App\api\Master\Models\M101\Item;
use App\Repositories\IItemRepository;

class DeleteItemAction
{
    private IItemRepository $itemRepository;

    public function __construct(
        IItemRepository $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    public function handle(Item $params): array
    {
        return $this->itemRepository->delete($params);
    }
}
