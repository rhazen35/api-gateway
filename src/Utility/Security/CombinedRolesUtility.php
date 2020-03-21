<?php

declare(strict_types=1);

namespace App\Utility\Security;

use App\Entity\User\GroupInterface;
use App\Entity\User\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait CombinedRolesUtility
{
    public static function getCombinedRoles(Collection $groups, Collection $roles): array
    {
        $combined = [];

        /** @var RoleInterface $role */
        foreach ($roles as $role) {
            if (!in_array($role->getRole(), $combined)) {
                $combined[] = $role->getRole();
            }
        }

        /** @var GroupInterface $group */
        foreach ($groups as $group) {

            if (!in_array($group->getRole(), $combined)) {
                $combined[] = $group->getRole();
            }

            $groupRoles = $group->getSecurityRoles();
            /** @var RoleInterface $role */
            foreach ($groupRoles as $role) {
                if (!in_array($role->getRole(), $combined)) {
                    $combined[] = $role->getRole();
                }
            }

            if (!$group->getChildGroups()->isEmpty()) {
                $combined = array_merge(
                    $combined,
                    self::getCombinedRoles($group->getChildGroups(), new ArrayCollection())
                 );
            }
        }

        return $combined;
    }
}