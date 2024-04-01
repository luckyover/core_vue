<?php

namespace App\api\System\Actions\M002;

use App\api\System\Models\M002\InitData;
use App\Repositories\ILibraryRepository;
use App\Utility\NameDiv;

class GetInitDataAction
{
    private ILibraryRepository $libraryRepository;

    public function __construct(
        ILibraryRepository $libraryRepository
    ) {
        $this->libraryRepository = $libraryRepository;
    }

    public function handle(): InitData
    {
        $response = new InitData;
        $libs = $this->libraryRepository->getLibs([
            NameDiv::BELONG_DEPARTMENT_DIV,
            NameDiv::AUTHORITY_DIV,
        ], true);
        $response->setBelongDepartmentDiv($libs[NameDiv::BELONG_DEPARTMENT_DIV]);
        $response->setAuthorityDiv($libs[NameDiv::AUTHORITY_DIV]);

        return $response;
    }
}
