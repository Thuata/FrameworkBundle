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

namespace Thuata\FrameworkBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thuata\FrameworkBundle\Tests\Interfaces\ReflectionTestInterface;
use Thuata\FrameworkBundle\Tests\Traits\ReflectionTestTrait;

/**
 * <b>AbstractKernelTest</b><br>
 *
 *
 * @package thuata\frameworkbundle\Tests
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 *
 * @method void assertTrue(bool $assertion)
 * @method void assertInstanceOf(string $expected, mixed $assertion)
 * @method void assertEquals(mixed $expected, mixed $assertion)
 */
class AbstractKernelTestCase extends KernelTestCase implements ReflectionTestInterface
{
    use ReflectionTestTrait;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }
}