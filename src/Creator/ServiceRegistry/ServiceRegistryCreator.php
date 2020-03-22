<?php

declare(strict_types=1);

namespace App\Creator\ServiceRegistry;

use App\Entity\ServiceRegistry\ServiceRegistry;
use App\Entity\ServiceRegistry\ServiceRegistryInterface;
use Doctrine\ORM\EntityManagerInterface;

final class ServiceRegistryCreator implements ServiceRegistryCreatorInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(ServiceRegistry $serviceRegistry): ServiceRegistryInterface
    {
        $this->entityManager->persist($serviceRegistry);
        $this->entityManager->flush();
    }
}