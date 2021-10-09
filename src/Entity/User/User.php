<?php

declare(strict_types=1);

namespace App\Entity\User;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    protected UuidV4 $id;

    /**
     * @ORM\Column(type="uuid", unique=true)
     */
    protected UuidV4 $externalId;

    /**
     * @ORM\Column(
     *     type="uuid",
     *     unique=true,
     *     nullable=true
     * )
     */
    protected ?UuidV4 $dataRequestId;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=255,
     *     nullable=true
     *     )
     */
    protected ?string $email;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    protected ?DateTimeImmutable $dataRequestedAt = null;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    protected DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    protected ?DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->id = Uuid::v4();
        $this->createdAt = new DateTimeImmutable();
    }

    public function getId(): UuidV4
    {
        return $this->id;
    }

    public function getExternalId(): UuidV4
    {
        return $this->externalId;
    }

    public function setExternalId(UuidV4 $externalId): self
    {
        $this->externalId = $externalId;

        return $this;
    }

    public function getDataRequestId(): ?UuidV4
    {
        return $this->dataRequestId;
    }

    public function setDataRequestId(?UuidV4 $dataRequestId): self
    {
        $this->dataRequestId = $dataRequestId;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDataRequestedAt(): ?DateTimeImmutable
    {
        return $this->dataRequestedAt;
    }

    public function setDataRequestedAt(?DateTimeImmutable $dataRequestedAt): self
    {
        $this->dataRequestedAt = $dataRequestedAt;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}