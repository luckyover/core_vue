<?php

namespace App\api\Master\Actions\M004;

use App\api\Master\Models\M004\Customer;
use App\Repositories\ICustomerRepository;

class GetCustomerDetailAction
{
    private ICustomerRepository $customerRepository;

    public function __construct(
        ICustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    public function handle(?string $id): Customer
    {
        return new Customer($this->customerRepository->find($id));
    }
}
