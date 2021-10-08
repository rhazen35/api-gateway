<?php

declare(strict_types=1);

namespace App\Handler\Request;

use App\Messenger\External\ExternalMessageFactory;
use App\Factory\Request\RequestDataFactory;
use App\Messenger\Stamp\Id\IdStamp;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class RequestHandler
{
    private RequestDataFactory $requestDataFactory;
    private ExternalMessageFactory $externalMessageFactory;
    private MessageBusInterface $messageBus;

    public function __construct(
        RequestDataFactory     $requestDataFactory,
        ExternalMessageFactory $externalMessageFactory,
        MessageBusInterface    $messageBus
    ) {
        $this->requestDataFactory = $requestDataFactory;
        $this->externalMessageFactory = $externalMessageFactory;
        $this->messageBus = $messageBus;
    }

    public function __invoke(Request $request): string
    {
        $requestData = $this
            ->requestDataFactory
            ->create($request);

        $message = $this
            ->externalMessageFactory
            ->create($requestData);

        $envelope = $this
            ->messageBus
            ->dispatch($message);

        /** @var IdStamp $idStamp */
        $idStamp = $envelope->last(IdStamp::class);

        return $idStamp->getId();
    }
}