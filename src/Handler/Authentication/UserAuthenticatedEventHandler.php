<?php

declare(strict_types=1);

namespace App\Handler\Authentication;

use App\Enum\Authentication\Channel;
use App\Handler\Contract\HandlerInterface;
use App\Messenger\Message;

class UserAuthenticatedEventHandler implements HandlerInterface
{
    public function supports(Message $message): bool
    {
        return Channel::USER_AUTHENTICATED === $message->getChannel();
    }

    public function __invoke(Message $message): void
    {
        dd($message->getPayload()['token']);
    }
}