<?php declare(strict_types=1);

namespace Monolog\Service\LevelBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;

class MonologServiceCompilerPass implements CompilerPassInterface
{
    /**
     * process
     *
     * @param ContainerBuilder $container
     *
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasExtension('monolog')) {
            return;
        }

        $config = $container->getExtensionConfig('monolog');

        foreach ($config as $item) {
            foreach ($item['handlers'] as $name => $handler) {
                if ('service' !== $handler['type']) {
                    continue;
                }

                $handlerAlias = sprintf('monolog.handler.%s', $name);
                $serviceAlias = sprintf('monolog.service_level.%s', $name);

                if (!$container->hasDefinition($handler['id'])) {
                    throw new LogicException(sprintf('Service id "%s" does not exist', $handler['id']));
                }

                $definition = clone $container->getDefinition($handler['id']);
                $definition->addMethodCall('setLevel', [$handler['level']]);

                $container->addDefinitions([$serviceAlias => $definition]);
                $container->setAlias($handlerAlias, $serviceAlias);
            }
        }
    }
}
