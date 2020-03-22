<?php

namespace App\Entity\ServiceRegistry;

interface ServiceRegistryInterface
{
    public function getName(): ?string;

    public function setName($name): void;

    public function getHost(): ?string;

    public function setHost($host): void;

    public function getPort(): ?int;

    public function setPort($port): void;

    public function isActive(): bool;

    public function setActive($active): void;
}