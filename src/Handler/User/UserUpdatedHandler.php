<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Enum\User\Channel;
use App\Enum\User\Properties;
use App\Handler\Contract\HandlerInterface;
use App\Messenger\Message;
use App\Provider\User\UserProvider;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\UuidV4;

class UserUpdatedHandler implements HandlerInterface
{
    private UserProvider $userProvider;
    private UpdateUserHandler $updateUserHandler;

    public function __construct(
        UserProvider $userProvider,
        UpdateUserHandler $updateUserHandler
    ) {
        $this->userProvider = $userProvider;
        $this->updateUserHandler = $updateUserHandler;
    }

    public function supports(Message $message): bool
    {
        return Channel::USER_UPDATED === $message->getChannel();
    }

    /**
     * @throws NonUniqueResultException
     * @throws EntityNotFoundException
     */
    public function __invoke(Message $message): void
    {
        $payload = $message->getPayload();
        $id = $payload[Properties::ID] ?? null;

        if (null === $id) {
            return;
        }

        $user = $this
            ->userProvider
            ->getUserByExternalId(UuidV4::fromRfc4122($id));

        $this
            ->updateUserHandler
            ->__invoke(
                $user,
                $message
            );
    }
}