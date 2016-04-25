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

namespace Thuata\FrameworkBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class AbstractController
 *
 * @package Thuata\Frameworkbundle\Controller
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class AbstractController extends Controller
{
    const SERVICE_FACTORY_ID = 'thuata_framework.servicefactory';
    const MANAGER_FACTORY_ID = 'thuata_framework.managerfactory';

    /**
     * Gets the service factory
     *
     * @return \Thuata\FrameworkBundle\Service\ServiceFactory
     */
    protected function getServiceFactory()
    {
        return $this->container->get(static::SERVICE_FACTORY_ID);
    }

    /**
     * Gets the manager factory
     *
     * @return \Thuata\FrameworkBundle\Manager\ManagerFactory
     */
    protected function getManagerFactory()
    {
        return $this->container->get(static::MANAGER_FACTORY_ID);
    }
}