<?php

namespace App\Factory\ApiToken;

use App\Entity\ApiToken\ApiTokenInterface;

interface ApiTokenFactoryInterface
{
    public function create(): ApiTokenInterface;

    public function createFromArray(array $data): ApiTokenInterface;
}