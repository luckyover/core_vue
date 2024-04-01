<?php

namespace App\api\Master\Actions\M005;

use App\Repositories\IDeliveryRepository;

class DeleteDeliveryAction
{
    private IDeliveryRepository $deliveryRepository;

    public function __construct(
        IDeliveryRepository $deliveryRepository
    ) {
        $this->deliveryRepository = $deliveryRepository;
    }

    public function handle(?int $delivery_cd)
    {
        $this->deliveryRepository->delete($delivery_cd);
    }
}
