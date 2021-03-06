<?php

declare(strict_types=1);

namespace App\Entity\User;

use App\Entity\BaseEntity\BaseEntity;
use App\Utility\Security\CombinedGroupsUtility;
use App\Utility\Security\CombinedRolesUtility;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\User\UserRepository")
 */
class User extends BaseEntity implements UserInterface, \Serializable
{
    use CombinedRolesUtility,
    CombinedGroupsUtility;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $username;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * @var null|string
     */
    protected $plainPassword;

    /**
     * @var null|string
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @var null|DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $lastLogin;

    /**
     * @var null|DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $currentLogin;

    /**
     * @var Collection|GroupInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\User\Group", inversedBy="users", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinTable(name="users_groups")
     */
    protected $groups;

    /**
     * @var Collection|RoleInterface[]
     * @ORM\ManyToMany(targetEntity="App\Entity\User\Role", inversedBy="users", cascade={"persist"}, orphanRemoval=true)
     * @ORM\JoinTable(name="users_roles")
     */
    protected $securityRoles;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->securityRoles = new ArrayCollection();
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getLastLogin(): ?DateTime
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    public function getCurrentLogin(): ?DateTime
    {
        return $this->currentLogin;
    }

    public function setCurrentLogin(?DateTime $currentLogin): void
    {
        $this->currentLogin = $currentLogin;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getGroups(): Collection
    {

        return self::getCombinedGroups($this->groups);
    }

    public function addGroup(GroupInterface $group): void
    {
        if (!$this->groups->contains($group)) {
            $this->groups->add($group);
            $group->addUser($this);
        }
    }

    public function removeGroup(GroupInterface $group): void
    {
        if ($this->groups->contains($group)) {
            $this->groups->removeElement($group);
            $group->removeUser($this);
        }
    }

    public function getRoles(): array
    {
        $roles = $this->securityRoles;
        $groups = $this->getGroups();

        return self::getCombinedRoles($groups, $roles);
    }

    public function getSecurityRoles()
    {
        return $this->securityRoles;
    }

    public function addSecurityRole(RoleInterface $role): void
    {
        if (!$this->securityRoles->contains($role)) {
            $this->securityRoles->add($role);
            $role->addUser($this);
        }
    }

    public function removeSecurityRole(RoleInterface $role): void
    {
        if ($this->securityRoles->contains($role)) {
            $this->securityRoles->removeElement($role);
            $role->removeUser($this);
        }
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->setPlainPassword(null);
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }
}