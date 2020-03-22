<?php

declare(strict_types=1);

namespace App\Creator\ServiceRegistry;

use App\Command\ServiceRegistry\ServiceRegistryCommand;
use Symfony\Component\HttpFoundation\Request;

final class ServiceRegistryCommandCreator implements ServiceRegistryCommandCreatorInterface
{
    public function fromRequest(Request $request)
    {
        $service = $request->get('service');
        $host = $request->get('host');
        $port = $request->get('port');

        $command = new ServiceRegistryCommand($service, $host, $port);

        // TODO: Dispatch the command using the messenger
    }
}