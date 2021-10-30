<?php

declare(strict_types=1);

namespace App\Provider\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\UuidV4;

class UserProvider
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByEmailOrNull(string $email): ?User
    {
        return $this
            ->userRepository
            ->findOneOrNullByEmail($email);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByDataRequestId(UuidV4 $dataRequestId): ?User
    {
        return $this
            ->userRepository
            ->findOneOrNullByDataRequestId($dataRequestId);
    }

    /**
     * @throws NonUniqueResultException
     * @throws EntityNotFoundException
     */
    public function getUserByExternalId(UuidV4 $id): User
    {
        return $this
            ->userRepository
            ->findOneByExternalId($id);
    }
}