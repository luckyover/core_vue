<?php

namespace App\api\Master\Actions\M006;

use App\api\Master\Models\M006\Supplier;
use App\Repositories\ISupplierRepository;

class GetSupplierDetailAction
{
    private ISupplierRepository $supplierRepository;

    public function __construct(
        ISupplierRepository $supplierRepository
    ) {
        $this->supplierRepository = $supplierRepository;
    }

    public function handle(?string $id, array $options): Supplier
    {
        return new Supplier($this->supplierRepository->find($id, $options));
    }
}
