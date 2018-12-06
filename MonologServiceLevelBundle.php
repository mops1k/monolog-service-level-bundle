<?php declare(strict_types=1);

namespace Monolog\Service\LevelBundle;

use Monolog\Service\LevelBundle\DependencyInjection\CompilerPass\MonologServiceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MonologServiceLevelBundle
 */
class MonologServiceLevelBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MonologServiceCompilerPass());
    }
}
