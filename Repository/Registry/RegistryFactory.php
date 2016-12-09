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

namespace Thuata\FrameworkBundle\Repository\Registry;

use Doctrine\ORM\EntityManager;
use MongoDB\Client;
use MongoDB\Database;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Thuata\ComponentBundle\Bridge\Doctrine\ShortcutNotationParser;
use Thuata\ComponentBundle\Registry\ClassAwareInterface;
use Thuata\ComponentBundle\Registry\RegistryInterface;
use Thuata\FrameworkBundle\Bridge\MongoDb\ConnectionFactory;
use Thuata\FrameworkBundle\Entity\EntityStackConfiguration;
use Thuata\FrameworkBundle\Exception\InvalidRegistryName;

/**
 * <b>RegistryFactory</b><br>
 * Defines a factory for registries. Registries can be added to the factory, then retrieved
 *
 * @package thuata\frameworkbundle\Repository\Registry
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class RegistryFactory implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var array
     */
    private static $registries = [];

    /**
     * @var array
     */
    private static $defaultRegistries = [];

    /**
     * Registers a registry
     *
     * @param string  $name
     * @param string  $className
     * @param boolean $replace
     */
    public static function registerRegistry(string $name, string $className, bool $replace = false)
    {
        if (!array_key_exists($name, self::$registries) or $replace) {
            self::$registries[$name] = $className;
        }
    }

    /**
     * Registers a registry
     */
    public static function setDefaultRegistries(array $registries)
    {
        foreach ($registries as $registry) {
            if (array_key_exists($registry, self::$registries)) {
                self::$defaultRegistries[] = $registry;
            } else {
                throw new InvalidRegistryName($registry);
            }
        }
    }

    /**
     * Inject dependencies using implemented interfaces to registry
     *
     * @param \Thuata\ComponentBundle\Registry\RegistryInterface $registry
     * @param string|null                                        $entityName
     * @param EntityManager                                      $entityManager
     *
     * @throws \Exception
     */
    private function injectDependencies(RegistryInterface $registry, $entityName = null, EntityManager $entityManager = null)
    {
        if (!($entityManager instanceof EntityManager)) {
            /** @var EntityManager $entityManager */
            $entityManager = $this->container->get('doctrine.orm.entity_manager');
        }

        if ($registry instanceof EntityManagerAwareInterface) {
            $registry->setEntityManager($entityManager);
        }

        if ($registry instanceof EntityRegistry) {
            if ($entityName === null) {
                throw new \Exception('Can\'t load an entity registry without entity name');
            }
            $registry->setEntityRepository($entityManager->getRepository($entityName));
        }

        if ($registry instanceof MongoDBAwareInterface) {
            if ($entityName === null) {
                throw new \Exception('Can\'t load a mongodb registry without entity name');
            }

            $collection = ConnectionFactory::getInstance()->getConnection()->getMongoDatabase()->selectCollection($entityName);
            $registry->setMongoDBCollection($collection);
        }

        if ($registry instanceof ClassAwareInterface) {

            $shortcutParser = new ShortcutNotationParser($entityName);
            $bundle = $this->container->get('kernel')->getBundle($shortcutParser->getBundleName());

            $stackConfiguration = new EntityStackConfiguration($bundle, $shortcutParser->getEntityName());

            if ($registry instanceof MongoDBAwareInterface) {
                $registry->setEntityClass($stackConfiguration->getDocumentClass());
            } else {
                $registry->setEntityClass($stackConfiguration->getEntityClass());
            }
        }
    }

    /**
     * Gets a registry from its name
     *
     * @param string        $registryName
     * @param string        $entityClass
     * @param EntityManager $entityManager
     *
     * @return RegistryInterface
     */
    public function getRegistry(string $registryName, $entityClass = null, EntityManager $entityManager = null)
    {
        if (!array_key_exists($registryName, self::$registries)) {
            throw new InvalidRegistryName($registryName);
        }

        $reflectionClass = new \ReflectionClass(self::$registries[$registryName]);

        /** @var RegistryInterface $instance */
        $instance = $reflectionClass->newInstance();

        $this->injectDependencies($instance, $entityClass, $entityManager);

        return $instance;
    }

    /**
     * Gets the default registries
     */
    public function getDefaultRegistries(): array
    {
        return self::$defaultRegistries;
    }
}