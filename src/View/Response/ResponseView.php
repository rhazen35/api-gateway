<?php

/*************************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Ruben Hazenbosch <rh@braune-digital.com>, Braune Digital GmbH
 *
 *  All rights reserved
 ************************************************************************/

declare(strict_types=1);

namespace App\View\Response;

class ResponseView
{
    public string $messageId;

    public function __construct(string $messageId)
    {
        $this->messageId = $messageId;
    }
}