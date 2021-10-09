<?php

declare(strict_types=1);

namespace App\Messenger\Query\User;

use App\Entity\User\User;
use App\Enum\User\Channel;
use App\Messenger\Contract\AbstractMessageFactory;
use App\Messenger\Query\Query;
use Symfony\Component\Messenger\Envelope;

class GetUserQueryFactory extends AbstractMessageFactory
{
    public function create(User $user): Envelope
    {
        $channel = Channel::GET_USER;
        $idStamp = $this->getIdStamp();
        $amqpStamp = $this->getAmqpStamp($channel);

        $userId = $user
            ->getExternalId()
            ->toRfc4122();

        $message = new Query(
            $channel,
            ['id' => $userId],
            $idStamp->getId(),
            null,
            true,
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