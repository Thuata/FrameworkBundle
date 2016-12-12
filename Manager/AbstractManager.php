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

namespace Thuata\FrameworkBundle\Manager;

use Thuata\ComponentBundle\SoftDelete\SoftDeleteInterface;
use Thuata\FrameworkBundle\Document\AbstractDocument;
use Thuata\FrameworkBundle\Entity\DocumentSerialization;
use Thuata\FrameworkBundle\Entity\Interfaces\DocumentSerializableInterface;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableTrait;
use Thuata\FrameworkBundle\Manager\Interfaces\ManagerFactoryAccessableInterface;
use Thuata\FrameworkBundle\Manager\Traits\ManagerFactoryAccessableTrait;
use Thuata\FrameworkBundle\Repository\AbstractRepository;
use Thuata\FrameworkBundle\Repository\Interfaces\RepositoryFactoryAccessableInterface;
use Thuata\FrameworkBundle\Entity\Interfaces\TimestampableInterface;
use Thuata\FrameworkBundle\Entity\AbstractEntity;
use Doctrine\Common\Collections\Collection;
use DateTime;
use Thuata\FrameworkBundle\Repository\Traits\RepositoryFactoryAccessableTrait;

/**
 * <b>AbstractManager</b><br>
 * Provides all base mechanics for managers
 *
 * @package Thuata\FrameworkBundle\Manager
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
abstract class AbstractManager implements FactorableInterface, ManagerFactoryAccessableInterface, RepositoryFactoryAccessableInterface
{
    use FactorableTrait,
        ManagerFactoryAccessableTrait,
        RepositoryFactoryAccessableTrait;

    protected $connectionName;

    /**
     * Returns the class name for the entity
     *
     * @return string
     */
    abstract protected function getEntityClassName(): string;

    /**
     * Gets the repository corresponding to the managed entity
     *
     * @return \Thuata\FrameworkBundle\Repository\AbstractRepository
     */
    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryFactory()->getRepositoryForEntity(
            AbstractRepository::getEntityNameFromClassName($this->getEntityClassName()),
            $this->connectionName
        );
    }

    /**
     * Sets connectionName
     *
     * @param mixed $connectionName
     *
     * @return AbstractManager
     */
    public function setConnectionName($connectionName)
    {
        $this->connectionName = $connectionName;

        return $this;
    }

    /**
     * Checks if entity class name implements interface
     *
     * @param string $interfaceName
     *
     * @return bool
     */
    protected function entityImplements(string $interfaceName): bool
    {
        $reflectionClass = new \ReflectionClass($this->getEntityClassName());

        return $reflectionClass->implementsInterface($interfaceName);
    }

    /**
     * Gets a new intance of an entity
     *
     * @return AbstractEntity
     */
    public function getNew(): AbstractEntity
    {
        $newEntity = $this->getRepository()->getNew();

        $this->prepareEntityForNew($newEntity);

        return $newEntity;
    }

    /**
     * Prepares an entity, setting its default values
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForNew(AbstractEntity $entity): bool
    {
        if ($entity instanceof TimestampableInterface) {
            $entity->setCreationDate(new DateTime());
            $entity->setEditionDate(new DateTime());
        }

        return $this->prepareEntityForGet($entity);
    }

    /**
     * Prepares an entity when retrieved from database
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForGet(AbstractEntity $entity): bool
    {
        if ($entity instanceof AbstractDocument) {
            $this->prepareDocumentForGet($entity);
        }
        return true;
    }

    /**
     * Prepares a document from MongoDB to be gotten
     *
     * @param AbstractDocument $entity
     *
     * @return bool
     */
    protected function prepareDocumentForGet(AbstractDocument $entity): bool
    {
        $document = $entity->getMongoDocument();

        if (!$document or empty($document)) {
            return true;
        }

        foreach ($document as $key => $value) {
            if (is_array($value) and array_key_exists('document_serialization', $value)){
                $documentEntity = $this->loadDocumentSerializedEntity($value);

                $entity->__set($key, $documentEntity);
            }
        }

        return true;
    }

    protected function loadDocumentSerializedEntity(array $serializationArray)
    {
        $serialization = DocumentSerialization::jsonDeserialize($serializationArray);

        /** @var AbstractManager $manager */
        $manager = $this->getManagerFactory()->getFactorableInstance($serialization->getManagerClass());

        /** @var DocumentSerializableInterface $entity */
        $entity = $manager->getNew();

        if (!($entity instanceof DocumentSerializableInterface)) {
            throw new \Exception('Entity "%s" does not implement interface "%s"', get_class($entity), DocumentSerializableInterface::class);
        }

        $entity->documentUnSerialize($serialization);

        $manager->prepareEntityForGet($entity);

        return $entity;
    }

    /**
     * Prepares an entity for persist
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForPersist(AbstractEntity $entity): bool
    {
        if ($entity instanceof TimestampableInterface) {
            $entity->setEditionDate(new DateTime());
        }

        return true;
    }

    /**
     * Prepares an entity for remove
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForRemove(AbstractEntity $entity): bool
    {
        return true;
    }

    /**
     * Prepares multiple entities for get
     *
     * @param Collection|array $entities
     *
     * @return boolean
     */
    protected function prepareEntitesForGet($entities): bool
    {
        foreach ($entities as $entity) {
            if ($this->prepareEntityForGet($entity) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Gets an entity by its ids
     *
     * @param integer $id
     *
     * @return AbstractEntity
     */
    public function getById($id): ?AbstractEntity
    {
        $entity = $this->getRepository()->findById($id);

        if ($entity instanceof AbstractEntity) {
            $this->prepareEntityForGet($entity);
        }

        return $entity;
    }

    /**
     * Gets Entities by criteria ...
     *
     * @param array $criteria
     * @param array $orders
     * @param int   $limit
     * @param int   $offset
     *
     * @return array
     */
    public function getEntitiesBy(array $criteria = [], array $orders = [], $limit = null, $offset = null): array
    {
        $entities = $this->getRepository()->findBy($criteria, $orders, $limit, $offset);
        $this->prepareEntitesForGet($entities);

        return $entities;
    }

    /**
     * Gets all entities matching a Criteria
     *
     * @param array $criteria
     * @param array $orders
     * @param int   $offset
     *
     * @return AbstractEntity
     */
    public function getOneEntityBy(array $criteria = [], array $orders = [], $offset = null): ?AbstractEntity
    {
        $entity = $this->getRepository()->findOneBy($criteria, $orders, $offset);

        if ($entity instanceof AbstractEntity) {
            $this->prepareEntityForGet($entity);
        }

        return $entity;
    }

    /**
     * Get entities with id in $ids
     *
     * @param array $ids
     *
     * @return array
     */
    public function getByIds(array $ids): array
    {

        $entities = $this->getRepository()->findByIds($ids);

        $this->prepareEntitesForGet($entities);

        return $entities;
    }

    /**
     * Persists an entity
     *
     * @param AbstractEntity $entity
     */
    public function persist(AbstractEntity $entity)
    {
        if ($this->prepareEntityForPersist($entity)) {
            $this->getRepository()->persist($entity);
        }

        $this->afterPersist($entity);
    }

    /**
     * Called after persist
     *
     * @param AbstractEntity $entity
     */
    protected function afterPersist(AbstractEntity $entity)
    {
        return;
    }

    /**
     * Removes an entity
     *
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity)
    {
        if ($this->prepareEntityForRemove($entity)) {
            $this->getRepository()->remove($entity);
        }
    }

    /**
     * Gets all applications
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->getEntitiesBy([]);
    }

    /**
     * Gets all entities not deleted
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getAllNotDeleted(): array
    {
        if (!$this->entityImplements(SoftDeleteInterface::class)) {
            throw new \Exception(sprintf('Entities of class "%s" do not implement interface "%s"', $this->getEntityClassName(), SoftDeleteInterface::class));
        }

        return $this->getEntitiesBy(['deleted' => false]);
    }
}
