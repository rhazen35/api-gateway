<?php

declare(strict_types=1);

namespace App\ViewTransformer\Response;

use App\View\Response\ResponseView;

class ResponseViewTransformer
{
    public function __invoke(string $messageId): ResponseView
    {
        return new ResponseView($messageId);
    }
}