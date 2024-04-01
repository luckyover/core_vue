<?php

namespace App\api\Master\Actions\M201;

use App\api\Master\Models\M201\InitData;
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
            NameDiv::PRICE_LIST,
        ], true);

        $response->setLib($libs[NameDiv::PRICE_LIST], 2);

        return $response;
    }
}
