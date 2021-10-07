<?php

/*************************************************************************
 *  Copyright notice
 *
 *  (c) 2021 Ruben Hazenbosch <rh@braune-digital.com>, Braune Digital GmbH
 *
 *  All rights reserved
 ************************************************************************/

declare(strict_types=1);

namespace App\Controller\Message;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublishAction
{
    public function __invoke(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content);

        return new JsonResponse(
            1234,
            Response::HTTP_ACCEPTED
        );
    }
}