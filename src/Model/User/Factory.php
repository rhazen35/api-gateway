<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Entity\User\User;
use Symfony\Component\Uid\Uuid;

class Factory
{
    public function createFromExternalId(string $externalId): User
    {
        $user = new User();
        $externalUuid = Uuid::v4()::fromRfc4122($externalId);

        $user->setExternalId($externalUuid);

        return $user;
    }
}