<?php

declare(strict_types=1);

namespace App\Utility\Security;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

trait CombinedGroupsUtility
{
    public static function getCombinedGroups(Collection $groups): Collection
    {
        $combined = new ArrayCollection();

        foreach ($groups as $group) {
            if (!$combined->contains($group)) {
                $combined->add($group);

                if (!$group->getChildGroups()->isEmpty()) {
                    $combined = new ArrayCollection(
                        array_merge(
                            $combined->toArray(),
                            self::getCombinedGroups($group->getChildGroups())->toArray()
                        )
                    );
                }
            }
        }

        return $combined;
    }
}