<?php

/*************************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Ruben Hazenbosch <rh@braune-digital.com>, Braune Digital GmbH
 *
 *  All rights reserved
 ************************************************************************/

declare(strict_types=1);

namespace App\Messenger\External;

use App\Messenger\Contract\MessageInterface;

class ExternalMessage implements MessageInterface
{
    private string $channel;
    private object $payload;
    private string $messageId;
    private ?string $originatedMessageId;

    public function __construct(
        string $channel,
        object $payload,
        string $messageId,
        ?string $originatedMessageId
    ) {
        $this->channel = $channel;
        $this->payload = $payload;
        $this->messageId = $messageId;
        $this->originatedMessageId = $originatedMessageId;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getPayload(): object
    {
        return $this->payload;
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function getOriginatedMessageId(): ?string
    {
        return $this->originatedMessageId;
    }
}