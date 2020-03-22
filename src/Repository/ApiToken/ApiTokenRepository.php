<?php

declare(strict_types=1);

namespace App\Repository\ApiToken;

use App\Entity\ApiToken\ApiToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ApiTokenRepository extends ServiceEntityRepository implements ApiTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiToken::class);
    }
}