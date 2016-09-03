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

use Thuata\FrameworkBundle\Tests\Resources\Service\Service;

/**
 * Description of ServiceFactoryTest
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class ServiceFactoryTest extends \Symfony\Bundle\FrameworkBundle\Test\KernelTestCase
{
    /**
     * testGetInstance
     */
    public function testGetInstance()
    {
        self::bootKernel();

        $factory = self::$kernel->getContainer()->get('thuata_framework.servicefactory');

        $factorable = $factory->getFactorableInstance(Service::class);
        
        $this->assertTrue($factorable instanceof Service);
    }
    
    /**
     * one factorable instance created, two loaded
     */
    public function testOnlyOneNew()
    {
        self::bootKernel();

        Service::$builds = 0;

        $factory = self::$kernel->getContainer()->get('thuata_framework.servicefactory');

        // first call
        $factorable = $factory->getFactorableInstance(Service::class);
        
        // second call
        $factorable = $factory->getFactorableInstance(Service::class);
        
        $this->assertEquals(1, Service::$builds);
    }
}
