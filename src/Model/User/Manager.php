<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;

class Manager
{
    private Factory $factory;
    private EntityManagerInterface $entityManager;

    public function __construct(
        Factory $factory,
        EntityManagerInterface $entityManager
    ) {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    public function createFromExternalIdAndEmailAndFlush(
        string $externalId,
        string $email
    ): User {
        $user = $this
            ->factory
            ->createFromExternalIdAndEmail(
                $externalId,
                $email
            );

        $this
            ->entityManager
            ->persist($user);

        $this
            ->entityManager
            ->flush();

        return $user;
    }
}