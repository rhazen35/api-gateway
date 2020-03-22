<?php

namespace App\Command\ApiToken;

use DateTimeInterface;

interface GenerateApiTokenCommandInterface
{
    public function getValid(): ?DateTimeInterface;
}