<?php

declare(strict_types=1);

namespace App\Controller\Message;

use App\Exception\Controller\JsonBody\EmptyJsonBodyException;
use App\Handler\Request\RequestHandler;
use App\Validator\Request\RequestValidator;
use App\ViewTransformer\Response\ResponseViewTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PublishAction
{
    private RequestValidator $requestValidator;
    private RequestHandler $requestHandler;
    private ResponseViewTransformer $responseViewTransformer;

    public function __construct(
        RequestValidator $requestValidator,
        RequestHandler $requestHandler,
        ResponseViewTransformer $responseViewTransformer
    ) {
        $this->requestValidator = $requestValidator;
        $this->requestHandler = $requestHandler;
        $this->responseViewTransformer = $responseViewTransformer;
    }

    /**
     * @throws EmptyJsonBodyException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this
            ->requestValidator
            ->validate($request);

        $messageId = $this
            ->requestHandler
            ->__invoke($request);

        $responseView = $this
            ->responseViewTransformer
            ->__invoke($messageId);

        return new JsonResponse(
            $responseView,
            Response::HTTP_ACCEPTED
        );
    }
}