<?php

namespace App\api\Master\Actions\M005;

use App\api\Master\Models\M005\ListOfDelivery;
use App\api\Master\Models\M005\SearchCondition;
use App\Models\AnsPaging;
use App\Repositories\IDeliveryRepository;

class SearchDeliveryAction
{
    private IDeliveryRepository $deliveryRepository;

    public function __construct(
        IDeliveryRepository $deliveryRepository
    ) {
        $this->deliveryRepository = $deliveryRepository;
    }

    public function handle(SearchCondition $condition): ListOfDelivery
    {
        $data = $this->deliveryRepository->search($condition);
        $result = new ListOfDelivery;
        $result->paging = new AnsPaging($data[1][0] ?? []);
        $result->setDelivery($data[0] ?? []);

        return $result;
    }
}
