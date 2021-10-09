<?php

declare(strict_types=1);

namespace App\Messenger\External;

use App\Factory\Request\RequestData;
use App\Messenger\Stamp\Amqp\AmqpStampFactory;
use App\Messenger\Stamp\Id\IdStampFactory;
use Symfony\Component\Messenger\Envelope;

class ExternalMessageFactory
{
    private AmqpStampFactory $amqpStampFactory;
    private IdStampFactory $idStampFactory;

    public function __construct(
        AmqpStampFactory $amqpStampFactory,
        IdStampFactory $idStampFactory
    ) {
        $this->amqpStampFactory = $amqpStampFactory;
        $this->idStampFactory = $idStampFactory;
    }

    public function create(
        RequestData $requestData,
        string $token
    ): Envelope {
        $idStamp = $this
            ->idStampFactory
            ->create();

        $amqpStamp = $this
            ->amqpStampFactory
            ->create($requestData->getChannel());

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