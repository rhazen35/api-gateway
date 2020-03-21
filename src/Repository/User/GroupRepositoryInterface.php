<?php

namespace App\Repository\User;

interface GroupRepositoryInterface
{
    public function findBy(array $array);

    public function findOneBy(array $array);
}