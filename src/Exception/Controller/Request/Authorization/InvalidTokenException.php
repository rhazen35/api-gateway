<?php

declare(strict_types=1);

namespace App\Exception\Controller\Request\Authorization;

use RuntimeException;

class InvalidTokenException extends RuntimeException
{
    protected $message = "The given token is not valid.";
}