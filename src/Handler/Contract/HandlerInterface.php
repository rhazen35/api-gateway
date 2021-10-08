<?php

namespace App\Handler\Contract;

use App\Messenger\Message;

interface HandlerInterface
{
    public function supports(Message $message): bool;

    public function __invoke(Message $message): void;
}