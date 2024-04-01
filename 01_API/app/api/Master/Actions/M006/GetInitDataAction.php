<?php

namespace App\api\Master\Actions\M006;

use App\api\Master\Models\M006\InitData;
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
            NameDiv::SUPPLIER_DIV,
            NameDiv::SUPPLIER_CLASS_DIV1,
            NameDiv::SUPPLIER_CLASS_DIV2,
            NameDiv::SUPPLIER_CLASS_DIV3,
            NameDiv::SUPPLIER_CLOSING_DIV,
            NameDiv::TRANSFER_DATE_1,
            NameDiv::TRANSFER_DATE_2,
        ], true);

        $response->setSupplierDiv($libs[NameDiv::SUPPLIER_DIV]);
        $response->setSupplierClassDiv1($libs[NameDiv::SUPPLIER_CLASS_DIV1]);
        $response->setSupplierClassDiv2($libs[NameDiv::SUPPLIER_CLASS_DIV2]);
        $response->setSupplierClassDiv3($libs[NameDiv::SUPPLIER_CLASS_DIV3]);
        $response->setSupplierClosingDiv($libs[NameDiv::SUPPLIER_CLOSING_DIV]);
        $response->setTransferDate1($libs[NameDiv::TRANSFER_DATE_1]);
        $response->setTransferDate2($libs[NameDiv::TRANSFER_DATE_2]);

        return $response;
    }
}
