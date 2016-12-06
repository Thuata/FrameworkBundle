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

namespace Thuata\FrameworkBundle\Entity;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Thuata\FrameworkBundle\Exception\ExctractEntityNameException;

/**
 * <b>EntityStackConfiguration</b><br>
 * Configures a stack generation to pass to the Inercession bundle that will generate the classes definitions.
 *
 * @package Thuata\FrameworkBundle\Entity
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class EntityStackConfiguration
{
    const MANAGER_NAME_FORMAT = '%sManager';
    const REPOSITORY_NAME_FORMAT = '%sRepository';
    const FILE_PATH_FORMAT = '%s/%s.php';
    const REPOSITORY_PATH_FORMAT = '%s/Repository/%s.php';
    const MANAGER_PATH_FORMAT = '%s/Manager/%s.php';
    const ENTITY_NAME_REGEXP_FORMAT = '#^%s/([^\\.]+)\\.php$#';
    const ENTITY_DIR_FORMAT = '%s/Entity';
    const ENTITY_NAMESPACE_FORMAT = '%s\\Entity';
    const DOCUMENT_NAMESPACE_FORMAT = '%s\\Document';
    const DOCUMENT_DIR_FORMAT = '%s/Document';
    const REPOSITORY_NAMESPACE_FORMAT = '%s\\Repository';
    const MANAGER_NAMESPACE_FORMAT = '%s\\Manager';

    /**
     * @var string
     */
    private $entityDir;
    /**
     * @var string
     */
    private $entityPath;
    /**
     * @var string
     */
    private $entityName;
    /**
     * @var string
     */
    private $documentDir;
    /**
     * @var string
     */
    private $documentPath;
    /**
     * @var string
     */
    private $managerName;
    /**
     * @var string
     */
    private $repositoryName;
    /**
     * @var string
     */
    private $managerPath;
    /**
     * @var string
     */
    private $repositoryPath;
    /**
     * @var string
     */
    private $entityNamespace;
    /**
     * @var string
     */
    private $documentNamespace;
    /**
     * @var string
     */
    private $managerNamespace;
    /**
     * @var string
     */
    private $repositoryNamespace;

    /**
     * EntityStackConfiguration constructor.
     *
     * @param Bundle $bundle
     * @param string $entityName
     */
    public function __construct(Bundle $bundle, string $entityName)
    {
        $this->entityName = $entityName;
        // names
        $this->managerName = sprintf(self::MANAGER_NAME_FORMAT, $this->getEntityName());
        $this->repositoryName = sprintf(self::REPOSITORY_NAME_FORMAT, $this->getEntityName());
        // pathes
        $this->entityDir = sprintf(self::ENTITY_DIR_FORMAT, $bundle->getPath());
        $this->entityPath = sprintf(self::FILE_PATH_FORMAT, $this->entityDir, $this->entityName);
        $this->documentDir = sprintf(self::DOCUMENT_DIR_FORMAT, $bundle->getPath());
        $this->documentPath = sprintf(self::FILE_PATH_FORMAT, $this->documentDir, $this->entityName);
        $this->managerPath = sprintf(self::MANAGER_PATH_FORMAT, $bundle->getPath(), $this->getManagerName());
        $this->repositoryPath = sprintf(self::REPOSITORY_PATH_FORMAT, $bundle->getPath(), $this->getRepositoryName());
        // namespaces
        $this->entityNamespace = sprintf(self::ENTITY_NAMESPACE_FORMAT, $bundle->getNamespace());
        $this->documentNamespace = sprintf(self::DOCUMENT_NAMESPACE_FORMAT, $bundle->getNamespace());
        $this->managerNamespace = sprintf(self::MANAGER_NAMESPACE_FORMAT, $bundle->getNamespace());
        $this->repositoryNamespace = sprintf(self::REPOSITORY_NAMESPACE_FORMAT, $bundle->getNamespace());
    }

    /**
     * Gets the dir for the entity
     *
     * @return string
     */
    public function getEntityDir()
    {
        return $this->entityDir;
    }

    /**
     * Gets the path to the entity
     *
     * @return string
     */
    public function getEntityPath()
    {
        return $this->entityPath;
    }

    /**
     * Gets the name of the entity
     *
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * Gets documentDir
     *
     * @return string
     */
    public function getDocumentDir(): string
    {
        return $this->documentDir;
    }

    /**
     * Gets documentPath
     *
     * @return string
     */
    public function getDocumentPath(): string
    {
        return $this->documentPath;
    }

    /**
     * Gets the manager name
     *
     * @return string
     */
    public function getManagerName()
    {
        return $this->managerName;
    }

    /**
     * Gets the repository name
     *
     * @return string
     */
    public function getRepositoryName()
    {
        return $this->repositoryName;
    }

    /**
     * Gets the manager path
     *
     * @return string
     */
    public function getManagerPath()
    {
        return $this->managerPath;
    }

    /**
     * Gets the repository path
     *
     * @return string
     */
    public function getRepositoryPath()
    {
        return $this->repositoryPath;
    }

    /**
     * Gets the entity namespace
     *
     * @return string
     */
    public function getEntityNamespace()
    {
        return $this->entityNamespace;
    }

    /**
     * Gets documentNamespace
     *
     * @return string
     */
    public function getDocumentNamespace(): string
    {
        return $this->documentNamespace;
    }

    /**
     * Gets the manager namespace
     *
     * @return string
     */
    public function getManagerNamespace()
    {
        return $this->managerNamespace;
    }

    /**
     * Gets the repository namespace
     *
     * @return string
     */
    public function getRepositoryNamespace()
    {
        return $this->repositoryNamespace;
    }

    /**
     * Gets the repository class
     *
     * @return string
     */
    public function getEntityClass()
    {
        return sprintf('%s\\%s', $this->getEntityNamespace(), $this->getEntityName());
    }

    /**
     * Gets the repository class
     *
     * @return string
     */
    public function getManagerClass()
    {
        return sprintf('%s\\%s', $this->getManagerNamespace(), $this->getManagerName());
    }

    /**
     * Gets the repository class
     *
     * @return string
     */
    public function getRepositoryClass()
    {
        return sprintf('%s\\%s', $this->getRepositoryNamespace(), $this->getRepositoryName());
    }

    /**
     * Gets the document class
     *
     * @return string
     */
    public function getDocumentClass()
    {
        return sprintf('%s\\%s', $this->getDocumentNamespace(), $this->getEntityName());
    }
}