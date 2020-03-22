<?php

namespace App\Entity\ApiToken;

use DateTimeInterface;

interface ApiTokenInterface
{
    public function getToken(): ?string;

    public function setToken(?string $token): void;

    public function getValid(): ?DateTimeInterface;

    public function setValid(?DateTimeInterface $valid): void;
}