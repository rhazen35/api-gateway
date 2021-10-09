<?php

declare(strict_types=1);

namespace App\Model\User;

use App\Entity\User\User;
use App\Provider\DateTime\DateTimeProvider;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class Manager
{
    private Factory $factory;
    private DateTimeProvider $dateTimeProvider;
    private EntityManagerInterface $entityManager;

    public function __construct(
        Factory $factory,
        DateTimeProvider $dateTimeProvider,
        EntityManagerInterface $entityManager
    ) {
        $this->factory = $factory;
        $this->dateTimeProvider = $dateTimeProvider;
        $this->entityManager = $entityManager;
    }

    public function createFromExternalIdAndFlush(string $externalId): User
    {
        $user = $this
            ->factory
            ->createFromExternalId($externalId);

        $this
            ->entityManager
            ->persist($user);

        $this
            ->entityManager
            ->flush();

        return $user;
    }

    public function updateDataRequestedAndFlush(
        User $user,
        string $dataRequestedId
    ): User {
        $dataRequestedId = Uuid::v4()::fromRfc4122($dataRequestedId);
        $requestedAt = $this
            ->dateTimeProvider
            ->getCurrentDateTimeImmutable();

        $user
            ->setDataRequestId($dataRequestedId)
            ->setDataRequestedAt($requestedAt);

        $this
            ->entityManager
            ->flush();

        return $user;
    }

    public function updateEmailAndRequestedAtAndFlush(
        User $user,
        string $email
    ): User {
        $user
            ->setEmail($email)
            ->setDataRequestId(null)
            ->setDataRequestedAt(null);

        $this
            ->entityManager
            ->flush();

        return $user;
    }
}