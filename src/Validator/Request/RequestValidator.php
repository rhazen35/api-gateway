<?php

declare(strict_types=1);

namespace App\Validator\Request;

use App\Exception\Controller\JsonBody\EmptyJsonBodyException;
use App\Exception\Controller\JsonBody\Property\ChannelPropertyDoesNotExistException;
use stdClass;
use Symfony\Component\HttpFoundation\Request;

class RequestValidator
{
    public function validate(Request $request): void
    {
        $requestParams = $request->request->all();
        $data = new stdClass();
        $payload = $requestParams['payload'] ?? null;
        $data->channel = $requestParams['channel'];
        $data->payload = null === $payload
            ? null
            : (object) $payload;

        if ([] === $requestParams) {
            throw new EmptyJsonBodyException();
        }

        $this->validateProperties($data);
    }

    /**
     * @param mixed $data
     */
    private function validateProperties($data): void
    {
        if (!property_exists($data, 'channel')) {
            throw new ChannelPropertyDoesNotExistException();
        }
    }
}