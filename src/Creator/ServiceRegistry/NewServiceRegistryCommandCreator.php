<?php

declare(strict_types=1);

namespace App\Creator\ServiceRegistry;

use App\Command\ServiceRegistry\NewServiceRegistryCommand;

final class NewServiceRegistryCommandCreator
{
    public function fromArray(array $data)
    {
        return new NewServiceRegistryCommand($data);
    }
}