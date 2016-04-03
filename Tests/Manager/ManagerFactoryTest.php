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
namespace Thuata\Tests\Manager;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Thuata\FrameworkBundle\Manager\ManagerFactory;
use Thuata\FrameworkBundle\Tests\Resources\Manager\Manager;

/**
 * Description of ManagerFactoryTest
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class ManagerFactoryTest extends TestCase
{
    /**
     * testGetInstance
     */
    public function testGetInstance()
    {
        $factory = new ManagerFactory();
        
        $factorable = $factory->getFactorableInstance(Manager::class);

        $this->assertTrue($factorable instanceof Manager);
    }
    
    /**
     * one factorable instance created, two loaded
     */
    public function testOnlyOneNew()
    {
        Manager::$builds = 0;

        $factory = new ManagerFactory();
        
        // first call
        $factorable = $factory->getFactorableInstance(Manager::class);
        
        // second call
        $factorable = $factory->getFactorableInstance(Manager::class);
        
        $this->assertEquals(1, Manager::$builds);
    }
}
