<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Enum\User\Channel;
use App\Handler\Contract\HandlerInterface;
use App\Messenger\Message;
use App\Model\User\Manager;

class UserCreatedHandler implements HandlerInterface
{
    private Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    public function supports(Message $message): bool
    {
        return Channel::USER_CREATED === $message->getChannel();
    }

    public function __invoke(Message $message): void
    {
        $payload = $message->getPayload();
        $id = $payload['id'] ?? null;
        $email = $payload['email'] ?? null;

        if (null === $id ||null === $email) {
            return;
        }

        $this
            ->manager
            ->createFromExternalIdAndEmailAndFlush(
                $id,
                $email
            );
    }
}