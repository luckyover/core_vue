<?php

namespace App\Repositories;

interface ISupplierRepository
{
    public function find($supplier_cd, $options);

    public function search($condition);

    public function suggestSearch($search);

    public function save($supplier);

    public function delete($supplier_cd);
}
