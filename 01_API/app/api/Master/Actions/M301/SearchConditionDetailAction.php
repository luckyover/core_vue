<?php

namespace App\api\Master\Actions\M301;

use App\api\Master\Models\M301\SearchCondition;
use App\Repositories\IProcessPriceRepository;

class SearchConditionDetailAction
{
    private IProcessPriceRepository $processPriceRepository;

    public function __construct(
        IProcessPriceRepository $processPriceRepository
    ) {
        $this->processPriceRepository = $processPriceRepository;
    }

    public function handle(SearchCondition $params): array
    {
        return $this->processPriceRepository->search($params) ?? [];
    }
}
