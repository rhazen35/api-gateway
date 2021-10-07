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

class PublishMessageFactory
{
    public function create(): PublishMessage
    {
        return new PublishMessage();
    }

    public function createFromArray(array $data): PublishMessage
    {
        $message = $this->create();

        $message
            ->setChannel($data['channel'])
            ->setPayload($data['payload']);

        return $message;
    }
}