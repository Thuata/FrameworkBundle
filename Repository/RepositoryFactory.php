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

namespace Thuata\FrameworkBundle\Repository;

use MongoDB\Client;
use Thuata\ComponentBundle\Bridge\Doctrine\ShortcutNotationParser;
use Thuata\FrameworkBundle\Entity\EntityStackConfiguration;
use Thuata\FrameworkBundle\Factory\AbstractFactory;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\ComponentBundle\Registry\RegistryableTrait;
use Thuata\FrameworkBundle\Repository\Registry\MongoDBAwareInterface;

/**
 * <b>RepositoryFactory</b><br>
 * Factory that allow to get repositories from an entity class
 *
 * @package Thuata\FrameworkBundle\Repository
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class RepositoryFactory extends AbstractFactory
{
    const REPOSITORY_REPLACE_REGEXP = '#\\\Entity\\\#';
    const REPOSITORY_FORMAT = '%sRepository';
    const ERROR_REPO_CLASS_INVALID = 'Repository class "%s" does not exist. Repositories should be defined beside the entity they manage.';

    use RegistryableTrait;

    /**
     * {@inheritdoc}
     */
    protected function injectDependancies(FactorableInterface $factorable)
    {
        /** @var \Thuata\FrameworkBundle\Repository\AbstractRepository $factorable */
        $factorable->setRegistryFactory($this->getContainer()->get('thuata_framework.registryfactory'));
        $factorable->setEntityManager($this->getContainer()->get('doctrine.orm.entity_manager'));

        if ($factorable instanceof MongoDBAwareInterface) {
            $client = new Client(sprintf('mongodb://%s:%d', $this->getContainer()->getParameter('mongo_host'), $this->getContainer()->getParameter('mongo_port')));
            $collection = $client->selectDatabase($this->getContainer()->getParameter('mongo_database'))->selectCollection($factorable->getEntityName());
            $factorable->setMongoDBCollection($collection);
        }
    }

    /**
     * Called when factorable is loaded
     *
     * @param FactorableInterface $factorable
     */
    protected function onFactorableLoaded(FactorableInterface $factorable)
    {
        /** @var AbstractRepository $factorable */
        $this->addToRegistry($factorable);
        $factorable->loadRegistries();
    }

    /**
     * Instanciates the factorable
     *
     * @param string $factorableClassName
     *
     * @return FactorableInterface
     *
     * @throws \Exception
     */
    protected function instanciateFactorable(string $factorableClassName)
    {
        $shortcutParser = new ShortcutNotationParser($factorableClassName);
        $bundle = $this->getContainer()->get('kernel')->getBundle($shortcutParser->getBundleName());

        $stackConfiguration = new EntityStackConfiguration($bundle, $shortcutParser->getEntityName());

        $reflectionClass = new \ReflectionClass($stackConfiguration->getRepositoryClass());

        /** @var \Thuata\FrameworkBundle\Repository\AbstractRepository $repository */
        $repository = $reflectionClass->newInstance();

        return $repository;
    }

    /**
     * Gets a service
     *
     * @param string $factorableClassName
     *
     * @return \Thuata\FrameworkBundle\Repository\AbstractRepository
     */
    public function getFactorableInstance(string $factorableClassName)
    {
        $factorable = $this->loadFromRegistry($factorableClassName);

        if (!$factorable instanceof AbstractRepository) {
            $factorable = parent::getFactorableInstance($factorableClassName);
        }

        return $factorable;
    }

    /**
     * Gets a repository for an entity
     *
     * @param string $entityName
     *
     * @return AbstractRepository
     */
    public function getRepositoryForEntity($entityName)
    {
        /** @var AbstractRepository $repository */
        $repository = $this->getFactorableInstance($entityName);

        return $repository;
    }
}
