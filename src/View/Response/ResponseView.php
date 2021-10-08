<?php

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