<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Utility\Security\CombinedRolesUtility;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleHierarchy;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user_security_group")
 * @ORM\Entity(repositoryClass="App\Repository\User\GroupRepository")
 */
class Group extends RoleHierarchy implements GroupInterface
{
    use CombinedRolesUtility;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $role;

    /**
     * @var Collection|UserInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\User\User", mappedBy="groups")
     */
    protected $users;

    /**
     * @var Collection|RoleInterface
     * @ORM\ManyToMany(targetEntity="App\Entity\User\Role", inversedBy="groups")
     * @ORM\JoinTable(name="security_groups_security_roles")
     */
    protected $securityRoles;

    /**
     * @var Collection|GroupInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\User\Group")
     * @ORM\JoinTable(name="user_security_groups_security_groups",
     *     joinColumns={@ORM\JoinColumn(name="user_group_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="child_group_id", referencedColumnName="id")}
     * )
     */
    protected $childGroups;

    public function __construct()
    {
        parent::__construct($hierarchy = []);
        $this->users = new ArrayCollection();
        $this->securityRoles = new ArrayCollection();
        $this->childGroups = new ArrayCollection();
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(UserInterface $user): void
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addGroup($this);
        }
    }

    public function removeUser(UserInterface $user): void
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeGroup($this);
        }
    }

    public function getSecurityRoles(): Collection
    {
        return $this->securityRoles;
    }

    public function getRoles(): array
    {
        $roles = $this->securityRoles;
        $groups = $this->getChildGroups();

        return self::getCombinedRoles($groups, $roles);
    }

    public function addSecurityRole(RoleInterface $role): void
    {
        if (!$this->securityRoles->contains($role)) {
            $this->securityRoles->add($role);
            $role->addGroup($this);
        }
    }

    public function removeSecurityRole(RoleInterface $role): void
    {
        if ($this->securityRoles->contains($role)) {
            $this->securityRoles->removeElement($role);
            $role->removeGroup($this);
        }
    }

    public function getChildGroups(): Collection
    {
        return $this->childGroups;
    }

    public function addChildGroup(GroupInterface $group): void
    {
        if (!$this->childGroups->contains($group)) {
            $this->childGroups->add($group);
        }
    }

    public function removeChildGroup(GroupInterface $group): void
    {
        if ($this->childGroups->contains($group)) {
            $this->childGroups->removeElement($group);
        }
    }
}