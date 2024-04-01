<?php

namespace App\api\Master\Actions\M006;

use App\api\Master\Models\M006\SupplierDetail;
use App\Repositories\ISupplierRepository;

class SaveSupplierAction
{
    private ISupplierRepository $supplierRepository;

    public function __construct(
        ISupplierRepository $supplierRepository
    ) {
        $this->supplierRepository = $supplierRepository;
    }

    public function handle(SupplierDetail $supplier): array
    {
        return $this->supplierRepository->save($supplier);
    }
}
