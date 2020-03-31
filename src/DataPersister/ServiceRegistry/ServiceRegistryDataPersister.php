<?php

declare(strict_types=1);

namespace App\DataPersister\ServiceRegistry;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Creator\ApiToken\GenerateApiTokenCommandCreator;
use App\Entity\ApiToken\ApiTokenInterface;
use App\Entity\ServiceRegistry\ServiceRegistry;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class ServiceRegistryDataPersister implements DataPersisterInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var MessageBusInterface */
    private $messageBus;

    /** @var GenerateApiTokenCommandCreator */
    private $apiTokenCommandCreator;

    public function __construct(
        EntityManagerInterface $entityManager,
        MessageBusInterface $messageBus,
        GenerateApiTokenCommandCreator $apiTokenCommandCreator
    )
    {
        $this->entityManager = $entityManager;
        $this->messageBus = $messageBus;
        $this->apiTokenCommandCreator = $apiTokenCommandCreator;
    }

    /**
     * @inheritDoc
     */
    public function supports($data): bool
    {
        return $data instanceof ServiceRegistry;
    }

    /**
     * @inheritDoc
     * @param ServiceRegistry $data
     * @throws Exception
     */
    public function persist($data)
    {
        $command = $this->apiTokenCommandCreator->createFromValid(null);

        /** @var ApiTokenInterface $apiToken */
        $envelope = $this->messageBus->dispatch($command);
        $handledStamp = $envelope->last(HandledStamp::class);
        $apiToken = $handledStamp->getResult();

        $data->addApiToken($apiToken);

        $data->setCreatedAt(new DateTime());
        $data->setCreatedBy($data->getCreatedBy());
        $data->setUpdatedAt(new DateTime());

        $data->setEnabled(true);

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