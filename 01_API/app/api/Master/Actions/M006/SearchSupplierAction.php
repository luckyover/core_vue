<?php

namespace App\api\Master\Actions\M006;

use App\api\Master\Models\M006\ListOfSupplier;
use App\api\Master\Models\M006\SearchCondition;
use App\Models\AnsPaging;
use App\Repositories\ISupplierRepository;

class SearchSupplierAction
{
    private ISupplierRepository $supplierRepository;

    public function __construct(
        ISupplierRepository $supplierRepository
    ) {
        $this->supplierRepository = $supplierRepository;
    }

    public function handle(SearchCondition $condition): ListOfSupplier
    {
        $data = $this->supplierRepository->search($condition);
        $result = new ListOfSupplier;
        $result->paging = new AnsPaging($data[1][0] ?? []);
        $result->setSuppliers($data[0] ?? []);

        return $result;
    }
}
