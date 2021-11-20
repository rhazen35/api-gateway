<?php

declare(strict_types=1);

namespace App\Messenger\Event\Authentication;

use App\Enum\Authentication\Channel;
use App\Messenger\Contract\AbstractMessageFactory;
use App\Messenger\Event\Event;
use Symfony\Component\Messenger\Envelope;

class TokenExpiredEventFactory extends AbstractMessageFactory
{
    public function create(string $token): Envelope
    {
        $channel = Channel::TOKEN_EXPIRED;
        $idStamp = $this->getIdStamp();
        $amqpStamp = $this->getAmqpStamp($channel);

        $message = new Event(
            $channel,
            ['token' => $token],
            $idStamp->getId(),
            null
        );

        return new Envelope(
            $message,
            [
                $amqpStamp,
                $idStamp,
            ]
        );
    }
}