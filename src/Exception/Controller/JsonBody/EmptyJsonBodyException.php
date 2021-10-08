<?php

declare(strict_types=1);

namespace App\Exception\Controller\JsonBody;

use RuntimeException;

class EmptyJsonBodyException extends RuntimeException
{
    protected $message = "The request must contain a JSON body.";
}