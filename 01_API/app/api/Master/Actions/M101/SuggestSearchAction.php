<?php

namespace App\api\Master\Actions\M101;

use App\Repositories\IItemRepository;

class SuggestSearchAction
{
    private IItemRepository $itemRepository;

    public function __construct(
        IItemRepository $itemRepository
    ) {
        $this->itemRepository = $itemRepository;
    }

    public function handle(array $search): array
    {
        return $this->itemRepository->suggestSearch($search);
    }
}
