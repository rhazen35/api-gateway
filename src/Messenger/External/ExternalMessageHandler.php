<?php

declare(strict_types=1);

namespace App\Messenger\External;

use App\Handler\Contract\HandlerInterface;
use App\Messenger\Exception\NoHandlerFoundException;
use App\Messenger\Message;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ExternalMessageHandler implements MessageHandlerInterface
{
    private iterable $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }

    public function __invoke(Message $message): void
    {
        $isHandled = false;
        /** @var HandlerInterface $handler */
        foreach ($this->handlers as $handler) {
            if ($handler->supports($message)) {
                $handler->__invoke($message);

                $isHandled = true;
                break;
            }
        }

        if (!$isHandled) {
            throw new NoHandlerFoundException(
                sprintf(
                    'No handler could be found for channel: %s.',
                    $message->getChannel()
                )
            );
        }
    }
}