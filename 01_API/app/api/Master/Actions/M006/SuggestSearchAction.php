<?php

namespace App\api\Master\Actions\M006;

use App\Repositories\ISupplierRepository;

class SuggestSearchAction
{
    private ISupplierRepository $supplierRepository;

    public function __construct(
        ISupplierRepository $supplierRepository
    ) {
        $this->supplierRepository = $supplierRepository;
    }

    public function handle(array $search): array
    {
        return $this->supplierRepository->suggestSearch($search);
    }
}
