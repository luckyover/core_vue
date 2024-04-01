<?php

namespace App\api\Master\Actions\M005;

use App\api\Master\Models\M005\Delivery;
use App\Repositories\IDeliveryRepository;

class GetDeliveryDetailAction
{
    private IDeliveryRepository $deliveryRepository;

    public function __construct(
        IDeliveryRepository $deliveryRepository
    ) {
        $this->deliveryRepository = $deliveryRepository;
    }

    public function handle(?int $id): Delivery
    {
        return new Delivery($this->deliveryRepository->find($id));
    }
}
