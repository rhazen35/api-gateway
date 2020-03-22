<?php

namespace App\Creator\ApiToken;

use App\Command\ApiToken\GenerateApiTokenCommand;
use DateTimeInterface;

interface GenerateApiTokenCommandCreatorInterface
{
    public function createFromValid(?DateTimeInterface $valid): GenerateApiTokenCommand;
}