<?php

namespace App\ServiceRegistry\Contracts;

use App\Command\ServiceRegistry\ServiceRegistryCommand;
use App\Entity\ServiceRegistry\ServiceRegistryInterface as RegistryInterface;

interface ServiceRegistryInterface
{
    public function register(ServiceRegistryCommand $command): RegistryInterface;

    public function destroy(): void;

    public function hasService(string $serviceName): bool;

    public function getService(string $serviceName);
}