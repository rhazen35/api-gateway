<?php

declare(strict_types=1);

namespace App\ServiceRegistry;

use App\ServiceRegistry\Contracts\ServiceRegistryInterface;

final class ServiceRegistry implements ServiceRegistryInterface
{
    public function register()
    {
        // TODO: Implement the register function
    }

    public function destroy()
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