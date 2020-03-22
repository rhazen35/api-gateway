<?php

declare(strict_types=1);

namespace App\Entity\ApiToken;

use App\Entity\ServiceRegistry\ServiceRegistryInterface;
use App\Entity\Traits\IdentifiableTrait;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="api_token")
 */
final class ApiToken implements ApiTokenInterface
{
    use IdentifiableTrait;

    /**
     * @var null|string
     * @ORM\Column(type="string", length=255)
     */
    protected $token;

    /**
     * @var null|DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    protected $expiresAt;

    /**
     * @var null|ServiceRegistryInterface
     *
     */
    protected $serviceRegistry;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getExpiresAt(): ?DateTimeInterface
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?DateTimeInterface $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getServiceRegistry()
    {
        return $this->serviceRegistry;
    }

    public function setServiceRegistry(ServiceRegistryInterface $serviceRegistry): void
    {
        $this->serviceRegistry = $serviceRegistry;
    }
}