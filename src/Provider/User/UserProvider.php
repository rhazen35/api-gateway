<?php

declare(strict_types=1);

namespace App\Provider\User;

use App\Entity\User\User;
use App\Repository\User\UserRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;

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
}