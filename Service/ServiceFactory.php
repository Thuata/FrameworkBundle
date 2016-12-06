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

namespace Thuata\FrameworkBundle\Service;

use Thuata\FrameworkBundle\Exception\InvalidServiceException;
use Thuata\FrameworkBundle\Exception\ServiceNotFoundException;
use Thuata\FrameworkBundle\Factory\AbstractFactory;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\ComponentBundle\Registry\RegistryableTrait;

/**
 * <b>ServiceFactory</b><br>
 * Factory for services
 *
 * @package Thuata\FrameworkBundle\Service
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class ServiceFactory extends AbstractFactory
{
    use RegistryableTrait;

    /**
     * {@inheritdoc}
     */
    protected function injectDependancies(FactorableInterface $factorable)
    {
        if (!($factorable instanceof AbstractService)) {
            throw new InvalidServiceException(get_class($factorable));
        }

        /** @var AbstractService $factorable */
        $managerFactory = $this->getContainer()->get('thuata_framework.managerfactory');

        $factorable->setManagerFactory($managerFactory);
    }

    /**
     * Called when factorable is loaded
     *
     * @param FactorableInterface $factorable
     */
    protected function onFactorableLoaded(FactorableInterface $factorable)
    {
        $this->addToRegistry($factorable);
    }

    /**
     * Gets a service
     *
     * @param string $factorableClassName
     *
     * @return AbstractService
     */
    public function getFactorableInstance(string $factorableClassName)
    {
        $factorable = $this->loadFromRegistry($factorableClassName);

        if (!$factorable instanceof AbstractService) {
            $factorable = parent::getFactorableInstance($factorableClassName);
        }

        return $factorable;
    }

    /**
     * Get a service by its class name or symfony service id
     * do the same as getFactorableInstance method, was created for convenience
     *
     * @param string $service
     *
     * @return \Thuata\FrameworkBundle\Service\AbstractService
     */
    public function getService(string $service): AbstractService
    {
        return $this->getFactorableInstance($service);
    }

    /**
     * @param string $factorableClassName
     *
     * @return \Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface
     */
    protected function instanciateFactorable(string $factorableClassName)
    {
        if (class_exists($factorableClassName)) {
            $service = parent::instanciateFactorable($factorableClassName);
        } elseif ($this->getContainer()->has($factorableClassName)) {
            $service = $this->getContainer()->get($factorableClassName);
        } else {
            throw new ServiceNotFoundException($factorableClassName);
        }

        return $service;
    }
}
