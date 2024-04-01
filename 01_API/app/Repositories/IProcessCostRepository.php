<?php

namespace App\Repositories;

interface IProcessCostRepository
{
    public function search($input): array;

    public function save($input): array;

    public function delete($input): array;
}
