<?php

namespace App\api\Master\Actions\M302;

use App\api\Master\Models\M302\PostProcessCost;
use App\Repositories\IProcessCostRepository;

class SaveProcessCostAction
{
    private IProcessCostRepository $itemProcessCostRepository;

    public function __construct(
        IProcessCostRepository $itemProcessCostRepository
    ) {
        $this->itemProcessCostRepository = $itemProcessCostRepository;
    }

    public function handle(PostProcessCost $body): array
    {
        return $this->itemProcessCostRepository->save($body);
    }
}
