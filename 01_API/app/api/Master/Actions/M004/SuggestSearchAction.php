<?php

namespace App\api\Master\Actions\M004;

use App\Repositories\ICustomerRepository;

class SuggestSearchAction
{
    private ICustomerRepository $customerRepository;

    public function __construct(
        ICustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    public function handle(?string $search): array
    {
        return $this->customerRepository->suggestSearch($search);
    }
}
