<?php

declare(strict_types=1);

namespace App\Exception\Controller\JsonBody\Property;

use RuntimeException;

class PayloadPropertyDoesNotExistException extends RuntimeException
{
    protected $message = "The payload property does not exists in the JSON body.";
}