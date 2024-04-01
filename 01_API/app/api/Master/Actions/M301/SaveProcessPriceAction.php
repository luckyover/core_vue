<?php

namespace App\api\Master\Actions\M301;

use App\api\Master\Models\M301\PostProcessPrice;
use App\Repositories\IProcessPriceRepository;

class SaveProcessPriceAction
{
    private IProcessPriceRepository $processPriceRepository;

    public function __construct(
        IProcessPriceRepository $processPriceRepository
    ) {
        $this->processPriceRepository = $processPriceRepository;
    }

    public function handle(PostProcessPrice $processPrice): void
    {
        $this->processPriceRepository->save($processPrice);
    }
}
