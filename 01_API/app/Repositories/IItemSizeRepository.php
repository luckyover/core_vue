<?php

namespace App\Repositories;

interface IItemSizeRepository
{
    public function getSizes($input): array;
}
