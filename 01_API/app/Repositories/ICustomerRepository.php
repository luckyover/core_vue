<?php

namespace App\Repositories;

interface ICustomerRepository
{
    public function find($customer_cd);

    public function search($condition);

    public function suggestSearch($search);

    public function save($customer);

    public function delete($customer_cd);
}
