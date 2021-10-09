<?php

declare(strict_types=1);

namespace App\Provider\Authentication\Token;

use App\Exception\Controller\Request\Authorization\MissingAuthorizationHeaderException;
use Symfony\Component\HttpFoundation\Request;

class TokenProvider
{
    /**
     * @throws MissingAuthorizationHeaderException
     */
    public function getTokenFromRequest(Request $request): string
    {
        $authorizationHeader = $request
            ->headers
            ->get('Authorization');

        $hasAuthorizationBearer = $request
                ->headers
                ->has('Authorization')
            && 0 === strpos(
                $authorizationHeader,
                'Bearer '
            );

        if (!$hasAuthorizationBearer) {
            throw new MissingAuthorizationHeaderException();
        }

        return str_replace(
            'Bearer ',
            "",
            $authorizationHeader
        );
    }
}