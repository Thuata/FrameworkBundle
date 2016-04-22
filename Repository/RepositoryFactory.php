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

use Thuata\FrameworkBundle\Factory\AbstractFactory;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\FrameworkBundle\Repository\AbstractRepository;
use Thuata\ComponentBundle\Registry\RegistryableTrait;

/**
 * Description of RepositoryFactory
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
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
    }

    /**
     * Called when factorable is loaded
     *
     * @param FactorableInterface $factorable
     */
    protected function onFactorableLoaded(FactorableInterface $factorable)
    {
        $this->addToRegistry($factorable);
    }

    /**
     * Instanciates the factorable
     *
     * @param $factorableClassName
     *
     * @return FactorableInterface
     *
     * @throws \Exception
     */
    protected function instanciateFactorable($factorableClassName)
    {
        $doctrine = $this->getContainer()->get('doctrine');
        $entityName = $doctrine->getEntityManager()->getClassMetadata($factorableClassName)->getName();

        $repository = $doctrine->getRepository($entityName);

        return $repository;
    }

    /**
     * Gets a service
     *
     * @param string $factorableClassName
     *
     * @return AbstractRepository
     */
    public function getFactorableInstance($factorableClassName)
    {
        $factorable = $this->loadFromRegistry($factorableClassName);

        if (!$factorable instanceof AbstractRepository) {
            $factorable = parent::getFactorableInstance($factorableClassName);
        }

        return $factorable;
    }

    /**
     * Gets the thuata repository corresponding to the entity class passed as param
     *
     * @param string $entityClassName
     *
     * @return AbstractRepository
     *
     * @throws \Exception
     */
    public function getRepositoryForEntityClassName($entityClassName)
    {
        $namespaced = preg_replace(self::REPOSITORY_REPLACE_REGEXP, '\\Repository\\', $entityClassName);
        $repositoryClass = sprintf(self::REPOSITORY_FORMAT, $namespaced);

        if (!class_exists($repositoryClass)) {
            throw new \Exception(sprintf(self::ERROR_REPO_CLASS_INVALID, $repositoryClass));
        }

        return $this->getFactorableInstance($repositoryClass);
    }
}
