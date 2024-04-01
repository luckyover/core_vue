<?php

namespace App\Repositories;

interface ILibraryRepository
{
    public function find(string $name_div, bool $add_empty = false): array;

    public function getLibs(array $name_div, bool $add_empty = false): array;
}
