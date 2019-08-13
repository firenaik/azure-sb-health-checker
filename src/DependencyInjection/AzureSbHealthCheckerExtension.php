<?php

declare(strict_types=1);

namespace Tseguier\AzureSbHealthCheckerBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Tseguier\AzureSbHealthCheckerBundle\Service\HealthCheckerService;

final class AzureSbHealthCheckerExtension extends Extension
{
    public const AZURE_SB_HEALTH_CHECKER = 'tseguier.azure_sb_health_checker';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $serviceDefinition = $container->register(self::AZURE_SB_HEALTH_CHECKER, HealthCheckerService::class);
        $serviceDefinition->setAutoconfigured(true);
    }
}
