<?php

namespace App\api\Master\Actions\M101;

use App\api\Master\Models\M101\Item;
use App\api\Master\Models\M101\M101Data;
use App\Repositories\IItemRepository;
use App\Repositories\IItemSizeRepository;

class GetItemDetailAction
{
    private IItemRepository $itemRepository;

    private IItemSizeRepository $itemSizeRepository;

    public function __construct(
        IItemRepository $itemRepository,
        IItemSizeRepository $itemSizeRepository
    ) {
        $this->itemRepository = $itemRepository;
        $this->itemSizeRepository = $itemSizeRepository;
    }

    public function handle(Item $params): M101Data
    {
        $response = new M101Data;

        $response->item = new Item($this->itemRepository->find($params));
        $response->setSizes($this->itemSizeRepository->getSizes($params));

        return $response;
    }
}
