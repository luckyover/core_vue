<?php

namespace App\api\Master\Actions\M302;

use App\api\Master\Models\M302\SearchCondition;
use App\Repositories\IProcessCostRepository;

class SearchProcessCostAction
{
    private IProcessCostRepository $processCostRepository;

    public function __construct(
        IProcessCostRepository $processCostRepository
    ) {
        $this->processCostRepository = $processCostRepository;
    }

    public function handle(SearchCondition $params): array
    {
        return $this->processCostRepository->search($params);
    }
}
