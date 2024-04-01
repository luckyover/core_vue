<?php

namespace App\api\Master\Actions\M201;

use App\api\Master\Models\M201\PostSizesPrice;
use App\Repositories\ISizesPriceRepository;

class SaveSizesPriceAction
{
    private ISizesPriceRepository $sizesPriceRepository;

    public function __construct(
        ISizesPriceRepository $sizesPriceRepository
    ) {
        $this->sizesPriceRepository = $sizesPriceRepository;
    }

    public function handle(PostSizesPrice $sizesPrice): void
    {
        $this->sizesPriceRepository->save($sizesPrice);
    }
}
