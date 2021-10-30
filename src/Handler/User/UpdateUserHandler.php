<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Entity\User\User;
use App\Messenger\Message;
use App\Messenger\Query\User\GetUserQueryFactory;
use App\Messenger\Stamp\Id\IdStamp;
use App\Model\User\Manager;
use Symfony\Component\Messenger\MessageBusInterface;

class UpdateUserHandler
{
    private Manager $manager;
    private GetUserQueryFactory $getUserQueryFactory;
    private MessageBusInterface $queryBus;

    public function __construct(
        Manager $manager,
        GetUserQueryFactory $getUserQueryFactory,
        MessageBusInterface $queryBus
    ) {
        $this->manager = $manager;
        $this->getUserQueryFactory = $getUserQueryFactory;
        $this->queryBus = $queryBus;
    }

    public function __invoke(
        User $user,
        Message $message
    ): void {
        $envelope = $this
            ->getUserQueryFactory
            ->create($user);

        /** @var IdStamp $idStamp */
        $idStamp = $envelope->last(IdStamp::class);

        $this
            ->manager
            ->updateDataRequestedAndFlush(
                $user,
                $idStamp->getId()
            );

        $this
            ->queryBus
            ->dispatch($envelope);
    }
}