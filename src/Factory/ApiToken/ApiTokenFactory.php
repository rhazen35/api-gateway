<?php

declare(strict_types=1);

namespace App\Factory\ApiToken;

use App\Entity\ApiToken\ApiToken;
use App\Entity\ApiToken\ApiTokenInterface;

final class ApiTokenFactory implements ApiTokenFactoryInterface
{
    public function create(): ApiTokenInterface
    {
        return new ApiToken();
    }

    public function createFromArray(array $data): ApiTokenInterface
    {
        $apiToken = $this->create();
        $apiToken->setToken($data['token']);
        $apiToken->setValid($data['valid']);

        return $apiToken;
    }
}