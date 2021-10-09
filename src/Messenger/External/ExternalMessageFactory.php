<?php

declare(strict_types=1);

namespace App\Messenger\External;

use App\Factory\Request\RequestData;
use App\Messenger\Contract\AbstractMessageFactory;
use Symfony\Component\Messenger\Envelope;

class ExternalMessageFactory extends AbstractMessageFactory
{
    public function create(
        RequestData $requestData,
        ?string $token
    ): Envelope {
        $idStamp = $this->getIdStamp();
        $amqpStamp = $this->getAmqpStamp($requestData->getChannel());

        $message = new ExternalMessage(
            $requestData->getChannel(),
            $requestData->getPayload(),
            $idStamp->getId(),
            null,
            $token
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