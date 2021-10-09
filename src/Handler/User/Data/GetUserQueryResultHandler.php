<?php

declare(strict_types=1);

namespace App\Handler\User\Data;

use App\Enum\User\Channel;
use App\Handler\Contract\HandlerInterface;
use App\Messenger\Message;
use App\Model\User\Manager;
use App\Provider\User\UserProvider;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Uid\UuidV4;

class GetUserQueryResultHandler implements HandlerInterface
{
    private UserProvider $userProvider;
    private Manager $manager;

    public function __construct(
        UserProvider $userProvider,
        Manager $manager
    ) {
        $this->userProvider = $userProvider;
        $this->manager = $manager;
    }

    public function supports(Message $message): bool
    {
        return Channel::GET_USER_RESULT === $message->getChannel();
    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(Message $message): void
    {
        $payload = $message->getPayload();
        $email = $payload['email'] ?? null;

        if (null === $email) {
            return;
        }

        $dataRequestId = $message->getOriginatedMessageId();

        if (null === $dataRequestId) {
            return;
        }

        $dataRequestId = UuidV4::fromRfc4122($dataRequestId);

        $user = $this
            ->userProvider
            ->getByDataRequestId($dataRequestId);

        if (null === $user) {
            return;
        }

        $this
            ->manager
            ->updateEmailAndRequestedAtAndFlush(
                $user,
                $email
            );
    }
}