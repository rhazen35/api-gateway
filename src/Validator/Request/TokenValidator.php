<?php

declare(strict_types=1);

namespace App\Validator\Request;

use App\Exception\Controller\Request\Authorization\ExpiredTokenException;
use App\Exception\Controller\Request\Authorization\InvalidTokenException;
use App\Exception\Controller\Request\Authorization\MissingAuthorizationHeaderException;
use App\Provider\Authentication\Token\TokenProvider;
use App\Provider\User\UserProvider;
use Doctrine\ORM\NonUniqueResultException;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpFoundation\Request;

class TokenValidator
{
    private TokenProvider $tokenProvider;
    private JWTEncoderInterface $jwtEncoder;
    private UserProvider $userProvider;

    public function __construct(
        TokenProvider $tokenProvider,
        JWTEncoderInterface $jwtEncoder,
        UserProvider $userProvider
    ) {
        $this->tokenProvider = $tokenProvider;
        $this->jwtEncoder = $jwtEncoder;
        $this->userProvider = $userProvider;
    }

    /**
     * @throws MissingAuthorizationHeaderException
     * @throws NonUniqueResultException
     * @throws InvalidTokenException
     * @throws ExpiredTokenException
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

            $this->ensureUserExists($decoded);

        } catch (JWTDecodeFailureException $exception) {
            switch ($exception->getReason()) {
                case JWTDecodeFailureException::EXPIRED_TOKEN:
                    throw new ExpiredTokenException();
                case JWTDecodeFailureException::INVALID_TOKEN:
                case JWTDecodeFailureException::UNVERIFIED_TOKEN:
                    throw new InvalidTokenException();
                default:
                    throw new InvalidTokenException();
            }
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws InvalidTokenException
     */
    private function ensureUserExists(array $decoded): void
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
}