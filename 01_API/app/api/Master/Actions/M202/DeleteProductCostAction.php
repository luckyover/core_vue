<?php

namespace App\api\Master\Actions\M202;

use App\api\Master\Models\M202\PostDelProductCost;
use App\Repositories\IProductCostRepository;

class DeleteProductCostAction
{
    private IProductCostRepository $productCostRepository;

    public function __construct(
        IProductCostRepository $productCostRepository
    ) {
        $this->productCostRepository = $productCostRepository;
    }

    public function handle(PostDelProductCost $params): array
    {
        return $this->productCostRepository->delete($params);
    }
}
