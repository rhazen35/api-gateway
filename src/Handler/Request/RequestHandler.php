<?php

declare(strict_types=1);

namespace App\Handler\Request;

use App\Enum\Authentication\WhiteList;
use App\Factory\Request\RequestData;
use App\Messenger\External\ExternalMessageFactory;
use App\Factory\Request\RequestDataFactory;
use App\Messenger\Stamp\Id\IdStamp;
use App\Provider\Authentication\Token\TokenProvider;
use App\Validator\Request\TokenValidator;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class RequestHandler
{
    private TokenValidator $tokenValidator;
    private TokenProvider $tokenProvider;
    private RequestDataFactory $requestDataFactory;
    private ExternalMessageFactory $externalMessageFactory;
    private MessageBusInterface $messageBus;

    public function __construct(
        TokenValidator         $tokenValidator,
        TokenProvider          $tokenProvider,
        RequestDataFactory     $requestDataFactory,
        ExternalMessageFactory $externalMessageFactory,
        MessageBusInterface    $messageBus
    ) {
        $this->tokenValidator = $tokenValidator;
        $this->tokenProvider = $tokenProvider;
        $this->requestDataFactory = $requestDataFactory;
        $this->externalMessageFactory = $externalMessageFactory;
        $this->messageBus = $messageBus;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(Request $request): string
    {
        $requestData = $this
            ->requestDataFactory
            ->create($request);

        $token = $this->getToken($request, $requestData);

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

    /**
     * @throws NonUniqueResultException
     */
    private function getToken(
        Request $request,
        RequestData $requestData
    ): ?string {
        if (in_array($requestData->getChannel(), WhiteList::getList())) {
            return null;
        }

        $this
            ->tokenValidator
            ->__invoke($request);

        return $this
            ->tokenProvider
            ->getTokenFromRequest($request);
    }
}