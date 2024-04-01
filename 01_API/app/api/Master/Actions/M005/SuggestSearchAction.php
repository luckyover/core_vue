<?php

namespace App\api\Master\Actions\M005;

use App\Repositories\IDeliveryRepository;

class SuggestSearchAction
{
    private IDeliveryRepository $deliveryRepository;

    public function __construct(
        IDeliveryRepository $deliveryRepository
    ) {
        $this->deliveryRepository = $deliveryRepository;
    }

    public function handle(?string $search): array
    {
        return $this->deliveryRepository->suggestSearch($search);
    }
}
