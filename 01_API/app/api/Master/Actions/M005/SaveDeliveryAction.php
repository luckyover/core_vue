<?php

namespace App\api\Master\Actions\M005;

use App\api\Master\Models\M005\DeliveryDetail;
use App\Repositories\IDeliveryRepository;

class SaveDeliveryAction
{
    private IDeliveryRepository $deliveryRepository;

    public function __construct(
        IDeliveryRepository $deliveryRepository
    ) {
        $this->deliveryRepository = $deliveryRepository;
    }

    public function handle(DeliveryDetail $delivery): array
    {
        return $this->deliveryRepository->save($delivery);
    }
}
