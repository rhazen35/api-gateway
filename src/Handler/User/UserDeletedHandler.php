<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Enum\User\Channel;
use App\Enum\User\Properties;
use App\Handler\Contract\HandlerInterface;
use App\Messenger\Message;
use App\Model\User\Manager;
use App\Provider\User\UserProvider;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\UuidV4;

class UserDeletedHandler implements HandlerInterface
{
    private UserProvider $userProvider;
    private Manager $manager;

    public function __construct(
        UserProvider $userProvider,
        Manager $manager
    ) {
        $this->userProvider = $userProvider;
        $this->manager = $manager;
    }

    public function supports(Message $message): bool
    {
        return Channel::USER_DELETED === $message->getChannel();
    }

    /**
     * @throws NonUniqueResultException
     * @throws EntityNotFoundException
     */
    public function __invoke(Message $message): void
    {
        $payload = $message->getPayload();
        $userId = $payload[Properties::ID] ?? null;
        $externalId = UuidV4::fromRfc4122($userId);

        $user = $this
            ->userProvider
            ->getUserByExternalId($externalId);

        $this
            ->manager
            ->deleteAndFlush($user);
    }
}