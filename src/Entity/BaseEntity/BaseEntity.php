<?php

namespace App\Entity\BaseEntity;

use App\Entity\Traits\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\MappedSuperclass()
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=true)
 */
abstract class BaseEntity
{
    use IdentifiableTrait,
    TimestampableEntity,
    BlameableEntity,
    SoftDeleteableEntity;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $enabled = false;

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }
}
