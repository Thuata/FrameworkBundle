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

namespace Thuata\FrameworkBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Thuata\FrameworkBundle\Entity\EntityStackConfiguration;
use Thuata\FrameworkBundle\Tests\Interfaces\ReflectionTestInterface;
use Thuata\FrameworkBundle\Tests\Traits\ReflectionTestTrait;

/**
 * Class EntityStackConfigurationTest
 *
 * @package thuata\frameworkbundle\Tests\Resources\Entity
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
class EntityStackConfigurationTest extends KernelTestCase implements ReflectionTestInterface
{
    use ReflectionTestTrait;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets up the test
     */
    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();

        $this->generatorService = $this->container->get('thuata_framework.stackgeneratorservice');
    }

    /**
     * testGetEntityName
     */
    public function testGetEntityName()
    {
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');
        $configuration = new EntityStackConfiguration($bundle, 'Entity');

        $expected = 'Entity';

        $this->assertEquals($expected, $configuration->getEntityName());
    }

    /**
     * testGetRepositoryPath
     */
    public function testGetManagerName()
    {
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');
        $configuration = new EntityStackConfiguration($bundle, 'Entity');

        $expected = 'EntityManager';

        $this->assertEquals($expected, $configuration->getManagerName());
    }

    /**
     * testGetRepositoryPath
     */
    public function testGetRepositoryName()
    {
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');
        $configuration = new EntityStackConfiguration($bundle, 'Entity');

        $expected = 'EntityRepository';

        $this->assertEquals($expected, $configuration->getRepositoryName());
    }

    /**
     * testGetRepositoryPath
     */
    public function testGetEntityDir()
    {
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');
        $configuration = new EntityStackConfiguration($bundle, 'Entity');

        $expected = $bundle->getPath() . '/Entity';

        $this->assertEquals($expected, $configuration->getEntityDir());
    }

    /**
     * testGetRepositoryPath
     */
    public function testGetManagerPath()
    {
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');
        $configuration = new EntityStackConfiguration($bundle, 'Entity');

        $expected = $bundle->getPath() . '/Manager/EntityManager.php';

        $this->assertEquals($expected, $configuration->getManagerPath());
    }

    /**
     * testGetRepositoryPath
     */
    public function testGetRepositoryPath()
    {
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');
        $configuration = new EntityStackConfiguration($bundle, 'Entity');

        $expected = $bundle->getPath() . '/Repository/EntityRepository.php';

        $this->assertEquals($expected, $configuration->getRepositoryPath());
    }


}