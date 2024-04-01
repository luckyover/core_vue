<?php

namespace App\api\Master\Actions\M202;

use App\api\Master\Models\M202\SearchCondition;
use App\Repositories\IProductCostRepository;

class SearchProductCostAction
{
    private IProductCostRepository $productCostRepository;

    public function __construct(
        IProductCostRepository $productCostRepository
    ) {
        $this->productCostRepository = $productCostRepository;
    }

    public function handle(SearchCondition $params): array
    {
        return $this->productCostRepository->search($params);
    }
}
