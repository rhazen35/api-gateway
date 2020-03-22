<?php

declare(strict_types=1);

namespace App\Entity\ServiceRegistry;

use App\Entity\Traits\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="service_registry")
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRegistry\ServiceRegistryRepository")
 */
final class ServiceRegistry implements ServiceRegistryInterface
{
    use IdentifiableTrait;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $host;

    /**
     * @var null|int
     * @ORM\Column(type="integer", length=16)
     */
    protected $port;

    /**
     * @var false|boolean
     */
    protected $active = false;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost($host): void
    {
        $this->host = $host;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPort($port): void
    {
        $this->port = $port;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive($active): void
    {
        $this->active = $active;
    }
}