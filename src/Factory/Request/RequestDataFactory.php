<?php

declare(strict_types=1);

namespace App\Factory\Request;

use stdClass;
use Symfony\Component\HttpFoundation\Request;

class RequestDataFactory
{
    public function create(Request $request): RequestData
    {
        $requestParams = $request->request->all();
        $data = new stdClass();
        $data->channel = $requestParams['channel'];
        $data->payload = (object) $requestParams['payload'];

        return new RequestData($data->channel, $data->payload);
    }
}