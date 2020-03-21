<?php

declare(strict_types=1);

namespace App\DataPersister\User;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User\Role;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

final class RoleDataPersister implements DataPersisterInterface
{
    /** var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @inheritDoc
     */
    public function supports($data): bool
    {
        return $data instanceof Role;
    }

    /**
     * @inheritDoc
     */
    public function persist($data)
    {
        if ($data->getRole()) {
            $data->setRole(strtoupper($data->getRole()));
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * @inheritDoc
     */
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}