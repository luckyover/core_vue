<?php

namespace App\Repositories;

interface IUserRepository
{
    public function checkUserSwaggerLogin($account);

    public function checkUserLogin($account);

    public function find($user_cd);

    public function search($condition);

    public function suggestSearch($search);

    public function save($user);

    public function delete($user_cd);
}
