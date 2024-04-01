<?php

namespace App\api\Master\Actions\M101;

use App\api\Master\Models\M101\InitData;
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
            NameDiv::ITEM_CLASS_DIV,
            NameDiv::PROCESSING_TYPE_DIV,
            NameDiv::CATEGORY_DIV,
            NameDiv::MATERIAL_DIV,
            NameDiv::TAX_DIV,
            NameDiv::DISCONTINUED_DIV,
            NameDiv::DISCONTINUED_DISPLAY_DIV,
        ], true);

        $response->setLib($libs[NameDiv::ITEM_CLASS_DIV], 2);
        $response->setLib($libs[NameDiv::PROCESSING_TYPE_DIV], 3);
        $response->setLib($libs[NameDiv::CATEGORY_DIV], 4);
        $response->setLib($libs[NameDiv::MATERIAL_DIV], 5);
        $response->setLib($libs[NameDiv::TAX_DIV], 6);
        $response->setLib($libs[NameDiv::DISCONTINUED_DIV], 7);
        $response->setLib($libs[NameDiv::DISCONTINUED_DISPLAY_DIV], 8);

        return $response;
    }
}
