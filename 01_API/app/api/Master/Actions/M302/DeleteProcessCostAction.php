<?php

namespace App\api\Master\Actions\M302;

use App\api\Master\Models\M302\DeleteProcessCost;
use App\Repositories\IProcessCostRepository;

class DeleteProcessCostAction
{
    private IProcessCostRepository $itemProcessCostRepository;

    public function __construct(
        IProcessCostRepository $itemProcessCostRepository
    ) {
        $this->itemProcessCostRepository = $itemProcessCostRepository;
    }

    public function handle(DeleteProcessCost $body): array
    {
        return $this->itemProcessCostRepository->delete($body);
    }
}
