<?php

namespace App\api\Master\Actions\M201;

use App\api\Master\Models\M201\SearchCondition;
use App\Repositories\ISizesPriceRepository;

class SearchConditionDetailAction
{
    private ISizesPriceRepository $sizesPriceRepository;

    public function __construct(
        ISizesPriceRepository $sizesPriceRepository

    ) {
        $this->sizesPriceRepository = $sizesPriceRepository;
    }

    public function handle(SearchCondition $params): array
    {
        return $this->sizesPriceRepository->search($params) ?? [];
    }
}
