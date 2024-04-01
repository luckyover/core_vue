<?php

namespace App\api\Master\Actions\M201;

use App\api\Master\Models\M201\DeleteSizesPrice;
use App\Repositories\ISizesPriceRepository;

class DeleteSizesPriceAction
{
    private ISizesPriceRepository $sizesPriceRepository;

    public function __construct(
        ISizesPriceRepository $sizesPriceRepository
    ) {
        $this->sizesPriceRepository = $sizesPriceRepository;
    }

    public function handle(DeleteSizesPrice $sizesPrice): void
    {
        $this->sizesPriceRepository->delete($sizesPrice);
    }
}
