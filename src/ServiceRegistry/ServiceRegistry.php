<?php

declare(strict_types=1);

namespace App\ServiceRegistry;

use App\Command\ServiceRegistry\ServiceRegistryCommand;
use App\ServiceRegistry\Contracts\ServiceRegistryInterface;
use App\Entity\ServiceRegistry\ServiceRegistryInterface as RegistryInterface;

final class ServiceRegistry implements ServiceRegistryInterface
{
    public function register(ServiceRegistryCommand $command): RegistryInterface
    {

    }

    public function destroy(): void
    {
        // TODO: Implement the destroy function
    }

    public function hasService(string $serviceName): bool
    {
        // TODO: Implement the has service function
        return false;
    }

    public function getService(string $serviceName)
    {
        // TODO: Implement the get service function
    }
}