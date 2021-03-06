<?php

/*
 * The MIT License
 *
 * Copyright 2015 Anthony Maudry <amaudry@gmail.com>.
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

namespace Thuata\FrameworkBundle\Factory;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thuata\FrameworkBundle\Factory\Interfaces\DependenciesAwareInterface;
use Thuata\FrameworkBundle\Repository\AbstractRepository;

/**
 * <b>AbstractFactory</b><br>
 * Provides definition for factories
 *
 * @package Thuata\FrameworkBundle\Factory
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
abstract class AbstractFactory implements FactoryInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container
     *
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Gets the container
     *
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

    /**
     * Called when factorable is loaded
     *
     * @param FactorableInterface $factorable
     */
    protected function onFactorableLoaded(Factorable\FactorableInterface $factorable)
    {
    }

    /**
     * Instanciates the factorable
     *
     * @param string $factorableClassName
     *
     * @return FactorableInterface
     *
     * @throws \Exception
     */
    protected function instanciateFactorable(string $factorableClassName)
    {
        $reflectionClass = new \ReflectionClass($factorableClassName);

        if (!$reflectionClass->implementsInterface(Factorable\FactorableInterface::class)) {
            throw new \Exception('Trying to factory a class that does not implements FactorableInterface');
        }

        return $reflectionClass->newInstance();
    }

    /**
     * Loads a factorable instance
     *
     * @param string $factorableClassName
     *
     * @return FactorableInterface
     *
     * @throws \Exception
     */
    protected function loadFactorableInstance(string $factorableClassName)
    {
        $factorable = $this->instanciateFactorable($factorableClassName);

        $factorable->setFactory($this);

        $this->injectDependancies($factorable);
        $this->injectServices($factorable);

        return $factorable;
    }

    /**
     * Injects dependancies to a factorable
     *
     * @param Factorable\FactorableInterface $factorable
     */
    abstract protected function injectDependancies(Factorable\FactorableInterface $factorable);

    /**
     * Inject services in factorable if it requires any
     *
     * @param FactorableInterface $factorable
     */
    protected function injectServices(FactorableInterface $factorable)
    {
        if ($factorable instanceof DependenciesAwareInterface) {
            foreach ($factorable->getDependencies() as $prop => $value) {
                $reflectionProperty = new \ReflectionProperty(get_class($factorable), $prop);
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($factorable, $this->container->get($value));
            }
        }
    }

    /**
     * Instanciate a factorable from a class name and inject its dependancies.
     *
     * @param string $factorableClassName
     *
     * @return FactorableInterface
     *
     * @throws \Exception
     */
    public function getFactorableInstance(string $factorableClassName)
    {
        $factorable = $this->loadFactorableInstance($factorableClassName);

        $this->onFactorableLoaded($factorable);

        return $factorable;
    }
}
