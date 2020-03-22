<?php

declare(strict_types=1);

namespace App\Entity\ServiceRegistry;

use App\Entity\ApiToken\ApiTokenHolderInterface;
use App\Entity\ApiToken\ApiTokenInterface;
use App\Entity\Traits\IdentifiableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Table(name="service_registry")
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRegistry\ServiceRegistryRepository")
 */
final class ServiceRegistry implements ServiceRegistryInterface, ApiTokenHolderInterface
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

    /**
     * @var Collection|ApiTokenInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\ApiToken\ApiToken")
     * @ORM\JoinTable(name="service_registry_tokens",
     *     joinColumns={@JoinColumn(name="service_registry_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="api_token_id", referencedColumnName="id", unique=true)}
     *     )
     */
    protected $apiTokens;

    public function __construct()
    {
        $this->apiTokens = new ArrayCollection();
    }

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

    public function getTokens(): Collection
    {
        return $this->apiTokens;
    }

    public function addToken(ApiTokenInterface $token): void
    {
        if (!$this->apiTokens->contains($token)) {
            $this->apiTokens->add($token);
        }
    }

    public function removeToken(ApiTokenInterface $token): void
    {
        if ($this->apiTokens->contains($token)) {
            $this->apiTokens->removeElement($token);
        }
    }
}