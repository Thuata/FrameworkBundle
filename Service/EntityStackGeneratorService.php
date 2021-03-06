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

namespace Thuata\FrameworkBundle\Service;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Thuata\FrameworkBundle\Entity\EntityStackConfiguration;
use Thuata\FrameworkBundle\Manager\AbstractManager;
use Thuata\FrameworkBundle\Repository\AbstractRepository;
use Thuata\IntercessionBundle\Exception\NotWritableException;
use Thuata\IntercessionBundle\Intercession\IntercessionClass;
use Thuata\IntercessionBundle\Intercession\IntercessionMethod;
use Thuata\IntercessionBundle\Service\GeneratorService;

/**
 * <b>EntityStackGeneratorService</b><br>
 * Generates the whom entity stack from a configuration
 *
 * @package Thuata\FrameworkBundle\Service
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class EntityStackGeneratorService
{
    const MANAGER_PATH = '%s/%sManager.php';
    /**
     * @var GeneratorService
     */
    private $generator;

    /**
     * Sets the generator
     *
     * @param GeneratorService $generatorService
     */
    public function setGenerator(GeneratorService $generatorService)
    {
        $this->generator = $generatorService;
    }

    /**
     * Gets the generator
     *
     * @return GeneratorService
     */
    protected function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Gets the entity stack configuration for an entity
     *
     * @param \Symfony\Component\HttpKernel\Bundle\Bundle $bundle
     * @param string                                      $entityName
     *
     * @return \Thuata\FrameworkBundle\Entity\EntityStackConfiguration
     */
    protected function getEntityStackConfiguration(Bundle $bundle, string $entityName)
    {
        return new EntityStackConfiguration($bundle, $entityName);
    }

    /**
     * @param EntityStackConfiguration $configuration
     *
     * @return IntercessionClass
     */
    protected function makeManagerIntercessionClass(EntityStackConfiguration $configuration)
    {
        $intercessionClass = new IntercessionClass();

        $intercessionClass->setName($configuration->getManagerName());
        $intercessionClass->setNamespace($configuration->getManagerNamespace());
        $intercessionClass->setExtends(AbstractManager::class);
        $intercessionClass->addUse($configuration->getEntityNamespace() . '\\' . $configuration->getEntityName());

        $intercessionMethod = new IntercessionMethod();
        $intercessionMethod->setName('getEntityClassName');
        $intercessionMethod->setBody(sprintf(<<<EOT
return %s::class;
EOT
        , $configuration->getEntityName()));
        $intercessionMethod->setDescription('Returns the class name for the entity');
        $intercessionMethod->setTypeReturned('string');
        $intercessionMethod->setDeclaredTypeReturned(true);
        $intercessionClass->addMethod($intercessionMethod);

        return $intercessionClass;
    }

    /**
     * Renders the manager file
     *
     * @param EntityStackConfiguration $configuration
     *
     * @throws \Thuata\IntercessionBundle\Exception\NotWritableException
     */
    protected function renderManagerFile(EntityStackConfiguration $configuration)
    {
        $intercessionClass = $this->makeManagerIntercessionClass($configuration);

        $dir = $configuration->getEntityDir();

        if (!is_writable($dir)) {
            throw new NotWritableException($dir);
        }

        $this->getGenerator()->createClassDefinitionFile($intercessionClass, $configuration->getManagerPath());
    }

    /**
     * Makes the intercession class for the repository
     *
     * @param EntityStackConfiguration $configuration
     *
     * @return IntercessionClass
     */
    protected function makeRepositoryIntercessionClass(EntityStackConfiguration $configuration)
    {
        $intercessionClass = new IntercessionClass();
        
        $intercessionClass->setName($configuration->getRepositoryName());
        $intercessionClass->setNamespace($configuration->getRepositoryNamespace());
        $intercessionClass->setExtends(AbstractRepository::class);

        return $intercessionClass;
    }

    /**
     * Renders the repository file
     *
     * @param EntityStackConfiguration $configuration
     *
     * @throws \Thuata\IntercessionBundle\Exception\NotWritableException
     */
    protected function renderRepositoryFile(EntityStackConfiguration $configuration)
    {
        $intercessionClass = $this->makeRepositoryIntercessionClass($configuration);

        $this->getGenerator()->createClassDefinitionFile($intercessionClass, $configuration->getRepositoryPath());
    }

    /**
     * Renders the stack (Manager and repository) for an entity in a bundle
     *
     * @param Bundle $bundle
     * @param $entityName
     */
    public function renderEntityStack(Bundle $bundle, $entityName)
    {
        $configuration = $this->getEntityStackConfiguration($bundle, $entityName);

        $this->renderManagerFile($configuration);
        $this->renderRepositoryFile($configuration);
    }
}