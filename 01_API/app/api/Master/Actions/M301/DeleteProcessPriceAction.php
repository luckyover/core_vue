<?php

namespace App\api\Master\Actions\M301;

use App\api\Master\Models\M301\DeleteProcessPrice;
use App\Repositories\IProcessPriceRepository;

class DeleteProcessPriceAction
{
    private IProcessPriceRepository $processPriceRepository;

    public function __construct(
        IProcessPriceRepository $processPriceRepository
    ) {
        $this->processPriceRepository = $processPriceRepository;
    }

    public function handle(DeleteProcessPrice $processPrice): void
    {
        $this->processPriceRepository->delete($processPrice);
    }
}
