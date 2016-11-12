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

namespace Thuata\FrameworkBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thuata\FrameworkBundle\Entity\EntityStackConfiguration;
use Thuata\FrameworkBundle\Service\EntityStackGeneratorService;
use Thuata\FrameworkBundle\Tests\Interfaces\ReflectionTestInterface;
use Thuata\FrameworkBundle\Tests\Resources\Entity;
use Thuata\FrameworkBundle\Tests\Traits\ReflectionTestTrait;
use Thuata\IntercessionBundle\Service\GeneratorService;

/**
 * Class EntityStackGeneratorServiceTest
 *
 * @package thuata\frameworkbundle\Tests\Service
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class EntityStackGeneratorServiceTest extends KernelTestCase implements ReflectionTestInterface
{
    use ReflectionTestTrait;

    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var EntityStackGeneratorService
     */
    private $generatorService;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();

        $this->generatorService = $this->container->get('enjoy_framework.stackgeneratorservice');
    }

    public function testGeneratorService()
    {
        $this->assertTrue($this->generatorService instanceof EntityStackGeneratorService);
    }

    public function testGeneratorServiceIntercessionInjection()
    {
        $this->assertTrue($this->invokeMethod($this->generatorService, 'getGenerator') instanceof GeneratorService);
    }

    public function testGetEntityStackConfiguration()
    {
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');
        $this->assertTrue($this->invokeMethod($this->generatorService, 'getEntityStackConfiguration', [$bundle, 'EntityName']) instanceof EntityStackConfiguration);
    }
}