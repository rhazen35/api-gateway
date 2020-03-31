<?php

declare(strict_types=1);

namespace App\CommandHandler\ApiToken;

use App\Command\ApiToken\GenerateApiTokenCommand;
use App\Factory\ApiToken\ApiTokenFactoryInterface;
use App\Utility\API\ApiTokenCreatorUtility;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class GenerateApiTokenCommandHandler implements MessageHandlerInterface
{
    /** @var ApiTokenFactoryInterface */
    private $apiTokenFactory;

    /** @var ApiTokenCreatorUtility */
    private $apiTokenCreatorUtility;

    public function __construct(
        ApiTokenFactoryInterface $apiTokenFactory,
        ApiTokenCreatorUtility $apiTokenCreatorUtility
    )
    {
        $this->apiTokenFactory = $apiTokenFactory;
        $this->apiTokenCreatorUtility = $apiTokenCreatorUtility;
    }

    public function __invoke(GenerateApiTokenCommand $command)
    {
        return $this->apiTokenFactory->createFromArray([
            'token' => $this->apiTokenCreatorUtility->create(),
            'valid' => $command->getValid(),
        ]);
    }
}