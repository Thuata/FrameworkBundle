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

namespace Thuata\FrameworkBundle\Service;

use Thuata\FrameworkBundle\Factory\AbstractFactory;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\ComponentBundle\Registry\RegistryableTrait;

/**
 * <b>ServiceFactory</b><br>
 * Factory for services
 *
 * @package Thuata\FrameworkBundle\Service
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class ServiceFactory extends AbstractFactory
{
    use RegistryableTrait;

    /**
     * {@inheritdoc}
     */
    protected function injectDependancies(FactorableInterface $factorable)
    {
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
    public function getFactorableInstance($factorableClassName)
    {
        $factorable = $this->loadFromRegistry($factorableClassName);
        
        if (!$factorable instanceof AbstractService) {
            $factorable = parent::getFactorableInstance($factorableClassName);
        }
        
        return $factorable;
    }
}
