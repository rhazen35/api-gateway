<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Enum\User\Channel;
use App\Enum\User\Properties;
use App\Handler\Contract\HandlerInterface;
use App\Messenger\Message;
use App\Model\User\Manager;

class UserCreatedHandler implements HandlerInterface
{
    private Manager $manager;
    private UpdateUserHandler $updateUserHandler;

    public function __construct(
        Manager $manager,
        UpdateUserHandler $updateUserHandler
    ) {
        $this->manager = $manager;
        $this->updateUserHandler = $updateUserHandler;
    }

    public function supports(Message $message): bool
    {
        return Channel::USER_CREATED === $message->getChannel();
    }

    public function __invoke(Message $message): void
    {
        $payload = $message->getPayload();
        $id = $payload[Properties::ID] ?? null;

        if (null === $id) {
            return;
        }

        $user = $this
            ->manager
            ->createFromExternalIdAndFlush($id);

        $this
            ->updateUserHandler
            ->__invoke(
                $user,
                $message
            );
    }
}