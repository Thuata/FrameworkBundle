<?php

namespace Thuata\FrameworkBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * <b>ThuataFrameworkExtension</b><br>
 * Configuration for the Framework bundle
 *
 * @package Thuata\FrameworkBundle\DependencyInjection
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class ThuataFrameworkExtension extends Extension
{
    const PARAMETER_KEY = 'thuata_framework.config';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::PARAMETER_KEY, $config);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
