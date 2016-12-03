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
use Symfony\Component\HttpKernel\Bundle\Bundle;
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
     * testGetBundle
     *
     * @return \Symfony\Component\HttpKernel\Bundle\Bundle
     */
    public function testGetBundle()
    {
        /** @var Bundle $bundle */
        $bundle = $this->container->get('kernel')->getBundle('ThuataFrameworkBundle');

        $this->assertInstanceOf(Bundle::class, $bundle);

        return $bundle;
    }

    /**
     * testGetEntityStack
     *
     * @return \Thuata\FrameworkBundle\Entity\EntityStackConfiguration
     *
     * @depends testGetBundle
     */
    public function testGetEntityStack(Bundle $bundle)
    {
        $configuration = new EntityStackConfiguration($bundle, 'Entity');

        $this->assertInstanceOf(EntityStackConfiguration::class, $configuration);

        return $configuration;
    }

    /**
     * testGetEntityName
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetEntityName(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = 'Entity';

        $this->assertEquals($expected, $configuration->getEntityName());
    }

    /**
     * testGetRepositoryPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetEntityDir(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getPath() . '/Entity';

        $this->assertEquals($expected, $configuration->getEntityDir());
    }

    /**
     * testGetRepositoryPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetEntityPath(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getPath() . '/Entity/Entity.php';

        $this->assertEquals($expected, $configuration->getEntityPath());
    }

    /**
     * testGetRepositoryPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetEntityNameSpace(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Entity';

        $this->assertEquals($expected, $configuration->getEntityNamespace());
    }

    /**
     * testGetRepositoryPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetManagerName(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = 'EntityManager';

        $this->assertEquals($expected, $configuration->getManagerName());
    }

    /**
     * testGetRepositoryPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetManagerPath(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getPath() . '/Manager/EntityManager.php';

        $this->assertEquals($expected, $configuration->getManagerPath());
    }

    /**
     * testGetManagerClass
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetManagerClass(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Manager\\EntityManager';

        $this->assertEquals($expected, $configuration->getManagerClass());
    }

    /**
     * testGetRepositoryPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetRepositoryName(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = 'EntityRepository';

        $this->assertEquals($expected, $configuration->getRepositoryName());
    }

    /**
     * testGetRepositoryPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetRepositoryPath(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getPath() . '/Repository/EntityRepository.php';

        $this->assertEquals($expected, $configuration->getRepositoryPath());
    }

    /**
     * testGetDocumentDir
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetDocumentDir(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getPath() . '/Document';

        $this->assertEquals($expected, $configuration->getDocumentDir());
    }

    /**
     * testGetDocumentPath
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetDocumentPath(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getPath() . '/Document/Entity.php';

        $this->assertEquals($expected, $configuration->getDocumentPath());
    }

    /**
     * testGetDocumentNamespace
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetDocumentNamespace(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Document';

        $this->assertEquals($expected, $configuration->getDocumentNamespace());
    }

    /**
     * testGetManagerNamespace
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetManagerNamespace(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Manager';

        $this->assertEquals($expected, $configuration->getManagerNamespace());
    }

    /**
     * testGetRepositoryNamespace
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetRepositoryNamespace(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Repository';

        $this->assertEquals($expected, $configuration->getRepositoryNamespace());
    }

    /**
     * testGetEntityClass
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetEntityClass(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Entity\\Entity';

        $this->assertEquals($expected, $configuration->getEntityClass());
    }

    /**
     * testGetRepositoryClass
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetRepositoryClass(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Repository\\EntityRepository';

        $this->assertEquals($expected, $configuration->getRepositoryClass());
    }

    /**
     * testGetDocumentClass
     *
     * @param EntityStackConfiguration                    $configuration
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     *
     * @depends testGetEntityStack
     * @depends testGetBundle
     */
    public function testGetDocumentClass(EntityStackConfiguration $configuration, Bundle $bundle)
    {
        $expected = $bundle->getNamespace() . '\\Document\\Entity';

        $this->assertEquals($expected, $configuration->getDocumentClass());
    }
}