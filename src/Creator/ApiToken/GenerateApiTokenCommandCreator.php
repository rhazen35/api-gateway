<?php

declare(strict_types=1);

namespace App\Creator\ApiToken;

use App\Command\ApiToken\GenerateApiTokenCommand;
use DateTimeInterface;

final class GenerateApiTokenCommandCreator implements GenerateApiTokenCommandCreatorInterface
{
    public function createFromValid(?DateTimeInterface $valid): GenerateApiTokenCommand
    {
        return new GenerateApiTokenCommand($valid);
    }
}