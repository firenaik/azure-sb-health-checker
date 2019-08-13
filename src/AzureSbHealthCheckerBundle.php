<?php

declare(strict_types=1);

namespace Tseguier\AzureSbHealthCheckerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tseguier\AzureSbHealthCheckerBundle\DependencyInjection\AzureSbHealthCheckerCompilerPass;

final class AzureSbHealthCheckerBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AzureSbHealthCheckerCompilerPass());
    }
}
