<?php

namespace App\Repositories;

interface ISizesPriceRepository
{
    public function search($search);

    public function save($input): array;

    public function delete($input): array;
}
