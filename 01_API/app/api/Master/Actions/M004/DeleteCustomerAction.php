<?php

namespace App\api\Master\Actions\M004;

use App\Repositories\ICustomerRepository;

class DeleteCustomerAction
{
    private ICustomerRepository $customerRepository;

    public function __construct(
        ICustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    public function handle(?int $customer_cd)
    {
        $this->customerRepository->delete($customer_cd);
    }
}
