<?php

declare(strict_types=1);

namespace App\DataFixtures\User;

use App\Entity\User\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class RoleFixtures extends Fixture
{
    const ROLE_PREFIX = "ROLE_";

    const USER_CREATE = "USER_CREATE";
    const USER_READ = "USER_READ";
    const USER_UPDATE = "USER_UPDATE";
    const USER_DELETE = "USER_DELETE";

    const GROUP_CREATE = "GROUP_CREATE";
    const GROUP_READ = "GROUP_READ";
    const GROUP_UPDATE = "GROUP_UPDATE";
    const GROUP_DELETE = "GROUP_DELETE";

    const ROLE_CREATE = "ROLE_CREATE";
    const ROLE_READ = "ROLE_READ";
    const ROLE_UPDATE = "ROLE_UPDATE";
    const ROLE_DELETE = "ROLE_DELETE";

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $this->addSuperAdminRoles($manager);
        $this->addAdminRoles($manager);
    }

    public function addSuperAdminRoles(ObjectManager $manager): void
    {
        $groupRoles = [self::GROUP_CREATE, self::GROUP_READ, self::GROUP_UPDATE, self::GROUP_DELETE];
        $roleRoles = [self::ROLE_CREATE, self::ROLE_READ, self::ROLE_UPDATE, self::ROLE_DELETE];

        $this->persistRoles($groupRoles, $manager);
        $this->persistRoles($roleRoles, $manager);
    }

    public function addAdminRoles(ObjectManager $manager): void
    {
        $roles = [self::USER_CREATE, self::USER_READ, self::USER_UPDATE, self::USER_DELETE];

        $this->persistRoles($roles, $manager);
    }

    public function persistRoles(array $roles, ObjectManager $manager): void
    {
        foreach ($roles as $role) {
            $object = new Role();
            $object->setRole(self::ROLE_PREFIX.$role);

            $manager->persist($object);
            $manager->flush();
        }
    }
}