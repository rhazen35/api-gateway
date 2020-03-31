<?php

declare(strict_types=1);

namespace App\EventListener\JWT;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthenticationSuccessListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }

        $loginDate = new DateTime();

        if (!$user->getCurrentLogin()) {
            $user->setCurrentLogin($loginDate);
        }

        $user->setLastLogin($user->getCurrentLogin());
        $user->setCurrentLogin($loginDate);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

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