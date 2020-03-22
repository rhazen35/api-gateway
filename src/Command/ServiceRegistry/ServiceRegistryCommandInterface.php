<?php

namespace App\Command\ServiceRegistry;

interface ServiceRegistryCommandInterface
{
    public function getService(): string;

    public function getHost(): string;

    public function getPort(): int;
}