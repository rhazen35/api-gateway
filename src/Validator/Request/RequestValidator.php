<?php

/*************************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Ruben Hazenbosch <rh@braune-digital.com>, Braune Digital GmbH
 *
 *  All rights reserved
 ************************************************************************/

declare(strict_types=1);

namespace App\Validator\Request;

use App\Exception\Controller\JsonBody\EmptyJsonBodyException;
use App\Exception\Controller\JsonBody\Property\ChannelPropertyDoesNotExistException;
use App\Exception\Controller\JsonBody\Property\PayloadPropertyDoesNotExistException;
use Symfony\Component\HttpFoundation\Request;

class RequestValidator
{
    public function validate(Request $request): void
    {
        $content = $request->getContent();
        $data = json_decode($content);

        if (null === $data) {
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