<?php

declare(strict_types=1);

namespace App\Exception\Controller\Request\Authorization;

use RuntimeException;

class MissingAuthorizationHeaderException extends RuntimeException
{
    protected $message = "An authorization header is missing.";
}