<?php

declare(strict_types=1);

namespace App\Entity\ApiToken;

use App\Entity\ServiceRegistry\ServiceRegistryInterface;
use App\Entity\Traits\IdentifiableTrait;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="api_token")
 * @ORM\Entity(repositoryClass="App\Repository\ApiToken\ApiTokenRepository")
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
    protected $valid;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    public function getValid(): ?DateTimeInterface
    {
        return $this->valid;
    }

    public function setValid(?DateTimeInterface $valid): void
    {
        $this->valid = $valid;
    }
}