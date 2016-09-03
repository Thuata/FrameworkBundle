<?php

namespace Thuata\FrameworkBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Thuata\ComponentBundle\Hydrator\ColumnHydrator;

/**
 * <b>ThuataFrameworkExtension</b><br>
 * Configuration for the Framework bundle
 *
 * @package Thuata\FrameworkBundle\DependencyInjection
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class ThuataFrameworkExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        /* $config = */$this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
