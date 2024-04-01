<?php

namespace App\api\Master\Actions\M101;

use App\api\Master\Models\M101\ItemDetail;
use App\Repositories\IItemRepository;

class SaveItemAction
{
    private IItemRepository $itemRepository;

    public function __construct(
        IItemRepository $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    public function handle(ItemDetail $body): array
    {
        return $this->itemRepository->save($body);
    }
}
