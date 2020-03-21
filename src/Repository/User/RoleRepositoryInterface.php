<?php

namespace App\Repository\User;

interface RoleRepositoryInterface
{
    public function findBy(array $array);

    public function findOneBy(array $array);
}