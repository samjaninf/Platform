<?php

namespace Ds\Bundle\BpmBundle\DependencyInjection\Compiler\Bpm;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ApiPass
 */
class ApiPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('ds.bpm.collection.bpm.api')) {
            return;
        }

        $definition = $container->findDefinition('ds.bpm.collection.bpm.api');
        $services = $container->findTaggedServiceIds('ds.bpm.api');

        foreach ($services as $id => $tags) {
            foreach ($tags as $tag) {
                $alias = array_key_exists('alias', $tag) ? $tag['alias'] : null;
                $definition->addMethodCall('addApi', [ new Reference($id), $alias ]);
            }
        }
    }
}
