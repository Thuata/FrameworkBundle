<?php

namespace Thuata\FrameworkBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * <b>Configuration</b><br>
 * Configuration for the Framework bundle
 *
 * @package Thuata\FrameworkBundle\DependencyInjection
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    const ROOT_NODE = 'thuata_framework';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(self::ROOT_NODE);

        $rootNode
            ->children()
                ->arrayNode('default_registries')
                    ->beforeNormalization()
                        ->ifString()
                            ->then(function ($value) {
                                return array($value);
                            })
                    ->end()
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('registries')
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
