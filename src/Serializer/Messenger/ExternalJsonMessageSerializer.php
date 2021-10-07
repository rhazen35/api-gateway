<?php

declare(strict_types=1);

namespace App\Serializer\Messenger;

use App\Messenger\Publish\PublishMessageFactory;
use Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessageSerializer implements SerializerInterface
{
    private PublishMessageFactory $publishMessageFactory;

    public function __construct(PublishMessageFactory $publishMessageFactory)
    {
        $this->publishMessageFactory = $publishMessageFactory;
    }

    /**
     * @throws Exception
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        if (null === $body) {
            throw new Exception("A payload should be provided when sending a message.");
        }

        $data = json_decode($body, true);

        if (null === $data) {
            throw new Exception("The given payload is not valid. A stringified object is expected.");
        }

        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }

        $message = $this
            ->publishMessageFactory
            ->createFromArray($data);

        return new Envelope($message, $stamps);
    }

    /**
     * @throws Exception
     */
    public function encode(Envelope $envelope): array
    {
        throw new Exception('Transport & serializer not meant for sending messages');
    }
}