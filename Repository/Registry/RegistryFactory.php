<?php
/*
 * The MIT License
 *
 * Copyright 2015 Anthony Maudry <anthony.maudry@thuata.com>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Thuata\FrameworkBundle\Repository\Registry;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Thuata\ComponentBundle\Registry\RegistryInterface;
use Thuata\FrameworkBundle\Exception\InvalidRegistryName;

/**
 * <b>RegistryFactory</b><br>
 * Defines a factory for registries. Registries can be added to the factory, then retrieved
 *
 * @package thuata\frameworkbundle\Repository\Registry
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class RegistryFactory implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var array
     */
    private static $registries = [];

    /**
     * Registers a registry
     *
     * @param string  $name
     * @param string  $className
     * @param boolean $replace
     */
    public static function registerRegistry(string $name, string $className, bool $replace = false)
    {
        if (!array_key_exists($name, $className) or $replace) {
            self::$registries[ $name ] = $className;
        }
    }

    /**
     * Inject dependencies using implemented interfaces to registry
     *
     * @param \Thuata\ComponentBundle\Registry\RegistryInterface $registry
     */
    private function injectDependencies(RegistryInterface $registry)
    {
        if ($registry instanceof EntityManagerAwareInterface) {
            $registry->setEntityManager($this->container->get('doctrine.orm.entity_manager'));
        }
    }

    /**
     * Gets a registry from its name
     *
     * @param string $registryName
     *
     * @return RegistryInterface
     */
    public function getRegistry(string $registryName)
    {
        if (!array_key_exists(self::$registries, $registryName)) {
            throw new InvalidRegistryName($registryName);
        }

        $reflectionClass = new \ReflectionClass(self::$registries[ $registryName ]);

        /** @var RegistryInterface $instance */
        $instance = $reflectionClass->newInstance();

        $this->injectDependencies($instance);

        return $instance;
    }
}