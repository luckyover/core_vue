<?php

namespace App\api\Master\Actions\M004;

use App\api\Master\Models\M004\ListOfCustomers;
use App\api\Master\Models\M004\SearchCondition;
use App\Models\AnsPaging;
use App\Repositories\ICustomerRepository;

class SearchCustomerAction
{
    private ICustomerRepository $customerRepository;

    public function __construct(
        ICustomerRepository $customerRepository
    ) {
        $this->customerRepository = $customerRepository;
    }

    public function handle(SearchCondition $condition): ListOfCustomers
    {
        $data = $this->customerRepository->search($condition);
        $result = new ListOfCustomers;
        $result->paging = new AnsPaging($data[1][0] ?? []);
        $result->setCustomers($data[0] ?? []);

        return $result;
    }
}
