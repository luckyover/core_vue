<?php

namespace App\api\Master\Actions\M202;

use App\api\Master\Models\M202\PostProductCost;
use App\Repositories\IProductCostRepository;

class SaveProductCostAction
{
    private IProductCostRepository $productCostRepository;

    public function __construct(
        IProductCostRepository $productCostRepository
    ) {
        $this->productCostRepository = $productCostRepository;
    }

    public function handle(PostProductCost $param): array
    {
        return $this->productCostRepository->save($param);
    }
}
