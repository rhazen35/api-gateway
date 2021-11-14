<?php

declare(strict_types=1);

namespace App\Validator\Request;

use App\Exception\Controller\JsonBody\EmptyJsonBodyException;
use App\Exception\Controller\JsonBody\Property\ChannelPropertyDoesNotExistException;
use App\Exception\Controller\JsonBody\Property\PayloadPropertyDoesNotExistException;
use stdClass;
use Symfony\Component\HttpFoundation\Request;

class RequestValidator
{
    public function validate(Request $request): void
    {
        $requestParams = $request->request->all();
        $data = new stdClass();
        $data->channel = $requestParams['channel'];
        $data->payload = (object) $requestParams['payload'];

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

        if (!property_exists($data, 'payload')) {
            throw new PayloadPropertyDoesNotExistException();
        }
    }
}