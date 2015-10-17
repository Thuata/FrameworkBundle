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
namespace Thuata\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Thuata\FrameworkBundle\Tests\Resources\Repository\Repository;

/**
 * Description of RepositoryFactoryTest
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class RepositoryFactoryTest extends TestCase
{
    /**
     * testGetInstance
     */
    public function testGetInstance()
    {
        $factory = new \Thuata\FrameworkBundle\Repository\RepositoryFactory();
        
        $factorable = $factory->getFactorableInstance(Repository::class);
        
        $this->assertTrue($factorable instanceof Repository);
    }
    
    /**
     * one factorable instance created, two loaded
     */
    public function testOnlyOneNew()
    {
        Repository::$builds = 0;

        $factory = new \Thuata\FrameworkBundle\Repository\RepositoryFactory();
        
        // first call
        $factorable = $factory->getFactorableInstance(Repository::class);
        
        // second call
        $factorable = $factory->getFactorableInstance(Repository::class);
        
        $this->assertEquals(1, Repository::$builds);
    }
}
