<?php

namespace App\api\Master\Actions\M302;

use App\api\Master\Models\M302\InitData;
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
            NameDiv::CATEGORY_DIV,
            NameDiv::MATERIAL_DIV,
            NameDiv::PROCESSING_LOCATION_DIV,
            NameDiv::NUMBER_OF_COLOR_DIV,
        ], true);
        $response->setLib($libs[NameDiv::CATEGORY_DIV], 2);
        $response->setLib($libs[NameDiv::MATERIAL_DIV], 3);
        $response->setLib($libs[NameDiv::PROCESSING_LOCATION_DIV], 4);
        $response->setLib($libs[NameDiv::NUMBER_OF_COLOR_DIV], 5);

        return $response;
    }
}
