<?php

namespace App\api\Master\Actions\M006;

use App\Repositories\ISupplierRepository;

class DeleteSupplierAction
{
    private ISupplierRepository $supplierRepository;

    public function __construct(
        ISupplierRepository $supplierRepository
    ) {
        $this->supplierRepositor = $supplierRepository;
    }

    public function handle(?int $supplier_cd)
    {
        $this->supplierRepositor->delete($supplier_cd);
    }
}
