<?php

declare(strict_types=1);

namespace App\DataFixtures\User;

use App\Entity\User\Group;
use App\Repository\User\RoleRepositoryInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class GroupFixtures extends Fixture implements DependentFixtureInterface
{
    /** @var RoleRepositoryInterface */
    private $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $adminGroup = $this->persistGroup("ROLE_ADMIN", $this->getAdminRoles(), $manager);
        $this->persistGroup("ROLE_SUPER_ADMIN", $this->getSuperAdminRoles(), $manager, [$adminGroup]);
    }

    public function getSuperAdminRoles()
    {
        return $this->roleRepository->findBy([
            'role' => [
                // Groups
                'ROLE_GROUP_CREATE',
                'ROLE_GROUP_READ',
                'ROLE_GROUP_UPDATE',
                'ROLE_GROUP_DELETE',
                // Roles
                'ROLE_ROLE_CREATE',
                'ROLE_ROLE_READ',
                'ROLE_ROLE_UPDATE',
                'ROLE_ROLE_DELETE',
            ]
        ]);
    }

    public function getAdminRoles()
    {
        return $this->roleRepository->findBy([
            'role' => [
                'ROLE_USER_CREATE',
                'ROLE_USER_READ',
                'ROLE_USER_UPDATE',
                'ROLE_USER_DELETE',
            ]
        ]);
    }

    public function persistGroup(string $groupName, array $roles, ObjectManager $manager, $groups = [])
    {
        $group = new Group();
        $group->setRole($groupName);

        if ($roles) {
            foreach ($roles as $role) {
                $group->addSecurityRole($role);
            }
        }

        if ($groups) {
            foreach ($groups as $childGroup) {
                $group->addChildGroup($childGroup);
            }
        }

        $manager->persist($group);
        $manager->flush();

        return $group;
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [
            RoleFixtures::class,
        ];
    }
}