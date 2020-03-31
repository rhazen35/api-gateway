<?php

declare(strict_types=1);

namespace App\Utility\API;

use Exception;
use Psr\Log\LoggerInterface;

final class ApiTokenCreatorUtility
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function create()
    {
        try {
            return bin2hex(random_bytes(60));
        } catch (Exception $e) {
            $this->logger->critical('There was a problem creating the token: '.$e->getMessage());
            return false;
        }
    }
}