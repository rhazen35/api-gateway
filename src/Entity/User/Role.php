<?php

declare(strict_types=1);

namespace App\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleHierarchy;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user_security_role")
 * @ORM\Entity(repositoryClass="App\Repository\User\RoleRepository")
 */
class Role extends RoleHierarchy implements RoleInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var null|string
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $role;

    /**
     * @var Collection|GroupInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\User\Group", mappedBy="securityRoles")
     */
    protected $groups;

    /**
     * @var Collection|UserInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\User\User", mappedBy="securityRoles")
     */
    protected $users;

    public function __construct()
    {
        parent::__construct($hierarchy = []);
        $this->groups = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(GroupInterface $group): void
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->addSecurityRole($this);
        }
    }

    public function removeGroup(GroupInterface $group): void
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeSecurityRole($this);
        }
    }

    public function getUsers(): Collection
    {
        return $this->groups;
    }

    public function addUser(UserInterface $user): void
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addSecurityRole($this);
        }
    }

    public function removeUser(UserInterface $user): void
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeSecurityRole($this);
        }
    }
}