<?php

declare(strict_types=1);

namespace App\Command\ServiceRegistry;

final class ServiceRegistryCommand implements ServiceRegistryCommandInterface
{
    /**
     * @var string
     */
    protected $service;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var int
     */
    protected $port;

    /**
     * RegisterServiceRegistryCommand constructor.
     * @param string $service The name of the service that has te be registered
     * @param string $host The host where the service is located
     * @param int $port The port that specifies the exact location
     */
    public function __construct(string $service, string $host, int $port)
    {
        $this->service = $service;
        $this->host = $host;
        $this->port = $port;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }
}