<?php

declare(strict_types=1);

namespace App\Handler\Request;

use App\Messenger\External\ExternalMessageFactory;
use App\Factory\Request\RequestDataFactory;
use App\Messenger\Stamp\Id\IdStamp;
use App\Provider\Authentication\Token\TokenProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class RequestHandler
{
    private TokenProvider $tokenProvider;
    private RequestDataFactory $requestDataFactory;
    private ExternalMessageFactory $externalMessageFactory;
    private MessageBusInterface $messageBus;

    public function __construct(
        TokenProvider          $tokenProvider,
        RequestDataFactory     $requestDataFactory,
        ExternalMessageFactory $externalMessageFactory,
        MessageBusInterface    $messageBus
    ) {
        $this->tokenProvider = $tokenProvider;
        $this->requestDataFactory = $requestDataFactory;
        $this->externalMessageFactory = $externalMessageFactory;
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): string
    {
        $token = $this
            ->tokenProvider
            ->getTokenFromRequest($request);

        $requestData = $this
            ->requestDataFactory
            ->create($request);

        $message = $this
            ->externalMessageFactory
            ->create(
                $requestData,
                $token
            );

        $envelope = $this
            ->messageBus
            ->dispatch($message);

        /** @var IdStamp $idStamp */
        $idStamp = $envelope->last(IdStamp::class);

        return $idStamp->getId();
    }
}