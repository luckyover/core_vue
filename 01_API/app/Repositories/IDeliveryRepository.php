<?php

namespace App\Repositories;

interface IDeliveryRepository
{
    public function find($delivery_cd);

    public function search($condition);

    public function suggestSearch($search);

    public function save($delivery);

    public function delete($delivery_cd);
}
