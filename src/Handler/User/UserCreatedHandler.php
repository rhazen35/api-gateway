<?php

declare(strict_types=1);

namespace App\Handler\User;

use App\Enum\User\Channel;
use App\Handler\Contract\HandlerInterface;
use App\Messenger\Message;
use App\Messenger\Query\User\GetUserQueryFactory;
use App\Messenger\Stamp\Id\IdStamp;
use App\Model\User\Manager;
use Symfony\Component\Messenger\MessageBusInterface;

class UserCreatedHandler implements HandlerInterface
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

    public function supports(Message $message): bool
    {
        return Channel::USER_CREATED === $message->getChannel();
    }

    public function __invoke(Message $message): void
    {
        $payload = $message->getPayload();
        $id = $payload['id'] ?? null;

        if (null === $id) {
            return;
        }

        $user = $this
            ->manager
            ->createFromExternalIdAndFlush($id);

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