<?php

declare(strict_types=1);

namespace Tseguier\AzureSbHealthCheckerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Tseguier\AzureSbHealthCheckerBundle\Service\HealthCheckerService;
use WindowsAzure\ServiceBus\Internal\IServiceBus;

final class AzureSbHealthCheckerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $taggedServicesReferences = array_map(
            [$this, 'getReferenceFromName'],
            array_keys($container->findTaggedServiceIds(IServiceBus::class))
        );

        $serviceDefinition = $container->getDefinition(AzureSbHealthCheckerExtension::AZURE_SB_HEALTH_CHECKER, HealthCheckerService::class);
        $serviceDefinition->setArguments([$taggedServicesReferences]);
    }

    private function getReferenceFromName(string $serviceName): Reference
    {
        return new Reference(($serviceName));
    }
}
