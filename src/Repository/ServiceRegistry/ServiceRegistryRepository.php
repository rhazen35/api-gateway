<?php

declare(strict_types=1);

namespace App\Repository\ServiceRegistry;

use App\Entity\ServiceRegistry\ServiceRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ServiceRegistryRepository extends ServiceEntityRepository implements ServiceRegistryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceRegistry::class);
    }
}