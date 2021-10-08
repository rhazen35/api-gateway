<?php

declare(strict_types=1);

namespace App\Factory\Request;

use Symfony\Component\HttpFoundation\Request;

class RequestDataFactory
{
    public function create(Request $request): RequestData
    {
        $content = $request->getContent();
        $data = json_decode($content);

        return new RequestData($data->channel, $data->payload);
    }
}