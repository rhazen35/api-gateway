<?php

namespace App\Creator\ServiceRegistry;

use App\Entity\ServiceRegistry\ServiceRegistry;
use App\Entity\ServiceRegistry\ServiceRegistryInterface;

interface ServiceRegistryCreatorInterface
{
    /**
     * Persists a service registry to the database.
     *
     * @param ServiceRegistry $serviceRegistry
     * @return ServiceRegistryInterface
     */
    public function create(ServiceRegistry $serviceRegistry): ServiceRegistryInterface;
}