<?php

/*************************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Ruben Hazenbosch <rh@braune-digital.com>, Braune Digital GmbH
 *
 *  All rights reserved
 ************************************************************************/

declare(strict_types=1);

namespace App\Exception\Controller\JsonBody;

use RuntimeException;

class EmptyJsonBodyException extends RuntimeException
{
    protected $message = "The request must contain a JSON body.";
}