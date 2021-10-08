<?php

/*************************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Ruben Hazenbosch <rh@braune-digital.com>, Braune Digital GmbH
 *
 *  All rights reserved
 ************************************************************************/

declare(strict_types=1);

namespace App\Factory\Request;

class RequestData
{
    private string $channel;
    private object $payload;

    public function __construct(
        string $channel,
        object $payload
    ) {
        $this->channel = $channel;
        $this->payload = $payload;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getPayload(): object
    {
        return $this->payload;
    }
}