<?php

namespace App\Repositories\Implements;

use App\Repositories\ICompanyRepository;
use DbService;

class CompanyRepository implements ICompanyRepository
{
    public function getCompaniesForCombobox()
    {
        $result = DbService::execSQL('SPC_M001_INQ1', []);

        return $result[0] ?? [];
    }
}
