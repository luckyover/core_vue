<?php

namespace App\api\Master\Actions\M004;

use App\api\Master\Models\M004\InitData;
use App\Repositories\ICompanyRepository;
use App\Repositories\ILibraryRepository;
use App\Utility\NameDiv;

class GetInitDataAction
{
    private ILibraryRepository $libraryRepository;

    private ICompanyRepository $companyRepository;

    public function __construct(
        ILibraryRepository $libraryRepository,
        ICompanyRepository $companyRepository
    ) {
        $this->libraryRepository = $libraryRepository;
        $this->companyRepository = $companyRepository;
    }

    public function handle(): InitData
    {
        $response = new InitData;
        $libs = $this->libraryRepository->getLibs([
            NameDiv::CUSTOMER_CLASS_DIV_1,
            NameDiv::CUSTOMER_CLASS_DIV_2,
            NameDiv::CUSTOMER_CLASS_DIV_3,
            NameDiv::BILLING_CLOSING_DIV,
            NameDiv::TRANSFER_DATE_1,
            NameDiv::TRANSFER_DATE_2,
            NameDiv::PRICE_LIST_TYPE_DIV,
        ], true);
        $response->setBillingSourceCd($this->companyRepository->getCompaniesForCombobox());
        $response->setCustomerClassDiv1($libs[NameDiv::CUSTOMER_CLASS_DIV_1]);
        $response->setCustomerClassDiv2($libs[NameDiv::CUSTOMER_CLASS_DIV_2]);
        $response->setCustomerClassDiv3($libs[NameDiv::CUSTOMER_CLASS_DIV_3]);
        $response->setBillingClosingDiv($libs[NameDiv::BILLING_CLOSING_DIV]);
        $response->setTransferDate1($libs[NameDiv::TRANSFER_DATE_1]);
        $response->setTransferDate2($libs[NameDiv::TRANSFER_DATE_2]);
        $response->setPriceList($libs[NameDiv::PRICE_LIST_TYPE_DIV]);

        return $response;
    }
}
