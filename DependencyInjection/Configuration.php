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
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        /* $rootNode = */$treeBuilder->root('thuata_framework');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
