<?php

declare(strict_types=1);

namespace App\Command\ApiToken;

use DateTimeInterface;

final class GenerateApiTokenCommand
{
    /**
     * @var DateTimeInterface
     */
    protected $valid;

    public function __construct(?DateTimeInterface $valid)
    {
        $this->valid = $valid;
    }

    public function getValid(): ?DateTimeInterface
    {
        return $this->valid;
    }
}