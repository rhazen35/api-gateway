<?php

declare(strict_types=1);

namespace App\Utility\API;

use Exception;

final class ApiTokenCreatorUtility
{
    public function create(): string
    {
        try {
            return bin2hex(random_bytes(60));
        } catch (Exception $e) {
            // TODO: Log the error!
        }
    }
}