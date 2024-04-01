<?php

namespace App\Repositories;

interface IItemRepository
{
    public function find($input): array;

    public function refer($input): array;

    public function search($condition);

    public function suggestSearch($search);

    public function save($item): array;

    public function delete($input): array;
}
