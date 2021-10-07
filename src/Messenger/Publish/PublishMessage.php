<?php

/*************************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Ruben Hazenbosch <rh@braune-digital.com>, Braune Digital GmbH
 *
 *  All rights reserved
 ************************************************************************/

declare(strict_types=1);

namespace App\Messenger\Publish;

class PublishMessage
{
    private string $channel;
    private object $payload;

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getPayload(): object
    {
        return $this->payload;
    }

    public function setPayload(object $payload): self
    {
        $this->payload = $payload;

        return $this;
    }
}