<?php

declare(strict_types=1);

namespace App\Messenger\Serializer;

use Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class ExternalMessageSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];

        $data = json_decode($body, true);

        return new Envelope($data);
    }

    /**
     * @param Envelope $envelope
     *
     * @return array
     *
     * @throws Exception
     */
    public function encode(Envelope $envelope): array
    {
        throw new Exception('This transport was never meant to sent messages');
    }
}
