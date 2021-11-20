<?php

declare(strict_types=1);

namespace App\Validator\Request;

use App\Entity\User\User;
use App\Exception\Controller\Request\Authorization\ExpiredTokenException;
use App\Exception\Controller\Request\Authorization\InvalidTokenException;
use App\Exception\Controller\Request\Authorization\MissingAuthorizationHeaderException;
use App\Messenger\Event\Authentication\TokenExpiredEventFactory;
use App\Provider\Authentication\Token\TokenProvider;
use App\Provider\User\UserProvider;
use Doctrine\ORM\NonUniqueResultException;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class TokenValidator
{
    private TokenProvider $tokenProvider;
    private JWTEncoderInterface $jwtEncoder;
    private UserProvider $userProvider;
    private TokenExpiredEventFactory $tokenExpiredEventFactory;
    private MessageBusInterface $eventBus;

    public function __construct(
        TokenProvider $tokenProvider,
        JWTEncoderInterface $jwtEncoder,
        UserProvider $userProvider,
        TokenExpiredEventFactory $tokenExpiredEventFactory,
        MessageBusInterface $eventBus
    ) {
        $this->tokenProvider = $tokenProvider;
        $this->jwtEncoder = $jwtEncoder;
        $this->userProvider = $userProvider;
        $this->tokenExpiredEventFactory = $tokenExpiredEventFactory;
        $this->eventBus = $eventBus;
    }

    /**
     * @throws MissingAuthorizationHeaderException
     * @throws NonUniqueResultException
     * @throws InvalidTokenException
     * @throws JWTDecodeFailureException
     */
    public function __invoke(Request $request): void
    {
        $token = $this
            ->tokenProvider
            ->getTokenFromRequest($request);

        try {
            $decoded = $this
                ->jwtEncoder
                ->decode($token);

            $this->getUserFromDecoded($decoded);
        } catch (JWTDecodeFailureException $exception) {
            switch ($exception->getReason()) {
                case JWTDecodeFailureException::EXPIRED_TOKEN:
                    $this->dispatchTokenExpiredEvent($token);

                    return;
                case JWTDecodeFailureException::INVALID_TOKEN:
                case JWTDecodeFailureException::UNVERIFIED_TOKEN:
                    throw new InvalidTokenException();
                default:
                    throw new InvalidTokenException();
            }
        }
    }

    /**
     * @throws InvalidTokenException
     * @throws NonUniqueResultException
     */
    private function getUserFromDecoded(array $decoded): void
    {
        $email = $decoded['email'] ?? null;

        if (null === $email) {
            throw new InvalidTokenException();
        }

        $user = $this
            ->userProvider
            ->getByEmailOrNull($email);

        if (null === $user) {
            throw new InvalidTokenException();
        }
    }

    private function dispatchTokenExpiredEvent(string $token): void
    {
        $event = $this
            ->tokenExpiredEventFactory
            ->create($token);

        $this
            ->eventBus
            ->dispatch($event);
    }
}