<?php

namespace App\Repositories;

interface IProductCostRepository
{
    public function search($input);

    public function save($input): array;

    public function delete($input): array;
}
