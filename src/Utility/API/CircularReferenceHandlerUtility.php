<?php

declare(strict_types=1);

namespace App\Utility\API;

final class CircularReferenceHandlerUtility
{
    public function __invoke($object)
    {
        return $object->getId();
    }
}
