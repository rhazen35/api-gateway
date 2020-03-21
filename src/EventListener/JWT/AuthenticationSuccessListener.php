<?php

declare(strict_types=1);

namespace App\EventListener\JWT;

use DateTime;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthenticationSuccessListener
{
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $loginDate = new DateTime();
        $currentLogin = $user->getCurrentLogin();

        $user->setLastLogin(!$currentLogin ? $loginDate : null);
        $user->setCurrentLogin($loginDate);

        $data['data'] = [
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'lastLogin' => $user->getLastLogin(),
            'roles' => $user->getRoles(),
        ];

        $event->setData($data);
    }
}