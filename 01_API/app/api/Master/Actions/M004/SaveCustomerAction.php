<?php

namespace App\api\Master\Actions\M004;

use App\api\Master\Models\M004\CustomerDetail;
use App\Repositories\ICustomerRepository;

class SaveCustomerAction
{
    private ICustomerRepository $customerRepository;

    public function __construct(
        ICustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    public function handle(CustomerDetail $customer): array
    {
        return $this->customerRepository->save($customer);
    }
}
