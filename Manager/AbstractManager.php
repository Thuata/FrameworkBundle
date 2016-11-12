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

namespace Thuata\FrameworkBundle\Manager;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\DebugBundle\DependencyInjection\Compiler\DumpDataCollectorPass;
use Thuata\ComponentBundle\SoftDelete\SoftDeleteInterface;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableTrait;
use Thuata\FrameworkBundle\Manager\Interfaces\ManagerFactoryAccessableInterface;
use Thuata\FrameworkBundle\Manager\Traits\ManagerFactoryAccessableTrait;
<<<<<<< HEAD
=======
use Thuata\FrameworkBundle\Repository\AbstractRepository;
>>>>>>> feature/multi
use Thuata\FrameworkBundle\Repository\Interfaces\RepositoryFactoryAccessableInterface;
use Thuata\FrameworkBundle\Entity\Interfaces\TimestampableInterface;
use Thuata\FrameworkBundle\Entity\AbstractEntity;
use Doctrine\Common\Collections\Collection;
use \Doctrine\Common\Collections\Criteria;
use DateTime;
use Thuata\FrameworkBundle\Repository\Traits\RepositoryFactoryAccessableTrait;

/**
 * <b>AbstractManager</b><br>
 * Provides all base mechanics for managers
 *
 * @package Thuata\FrameworkBundle\Manager
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
abstract class AbstractManager implements FactorableInterface, ManagerFactoryAccessableInterface, RepositoryFactoryAccessableInterface
{
<<<<<<< HEAD

=======
>>>>>>> feature/multi
    use FactorableTrait,
        ManagerFactoryAccessableTrait,
        RepositoryFactoryAccessableTrait;

    /**
     * Returns the class name for the entity
     *
     * @return string
     */
<<<<<<< HEAD
    abstract protected function getEntityClassName();
=======
    abstract protected function getEntityClassName(): string;
>>>>>>> feature/multi

    /**
     * Gets the repository corresponding to the managed entity
     *
     * @return \Thuata\FrameworkBundle\Repository\AbstractRepository
     */
<<<<<<< HEAD
    protected function getRepository()
    {
        return $this->getRepositoryFactory()->getFactorableInstance($this->getEntityClassName());
=======
    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryFactory()->getFactorableInstance(AbstractRepository::getEntityNameFromClassName($this->getEntityClassName()));
>>>>>>> feature/multi
    }

    /**
     * Checks if entity class name implements interface
     *
     * @param string $interfaceName
     *
     * @return bool
     */
<<<<<<< HEAD
    protected function entityImplements(string $interfaceName)
=======
    protected function entityImplements(string $interfaceName): bool
>>>>>>> feature/multi
    {
        $reflectionClass = new \ReflectionClass($this->getEntityClassName());

        return $reflectionClass->implementsInterface($interfaceName);
    }

    /**
     * Gets a new intance of an entity
     *
     * @return AbstractEntity
     */
<<<<<<< HEAD
    public function getNew()
=======
    public function getNew(): AbstractEntity
>>>>>>> feature/multi
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
<<<<<<< HEAD
    protected function prepareEntityForNew(AbstractEntity $entity)
=======
    protected function prepareEntityForNew(AbstractEntity $entity): bool
>>>>>>> feature/multi
    {
        if ($entity instanceof TimestampableInterface) {
            $entity->setCreationDate(new DateTime());
            $entity->setEditionDate(new DateTime());
        }

        return true;
    }

    /**
     * Prepares an entity when retrieved from database
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
<<<<<<< HEAD
    protected function prepareEntityForGet(AbstractEntity $entity)
=======
    protected function prepareEntityForGet(AbstractEntity $entity): bool
>>>>>>> feature/multi
    {
        return true;
    }

    /**
     * Prepares an entity for persist
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
<<<<<<< HEAD
    protected function prepareEntityForPersist(AbstractEntity $entity)
=======
    protected function prepareEntityForPersist(AbstractEntity $entity): bool
>>>>>>> feature/multi
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
<<<<<<< HEAD
    protected function prepareEntityForRemove(AbstractEntity $entity)
=======
    protected function prepareEntityForRemove(AbstractEntity $entity): bool
>>>>>>> feature/multi
    {
        return true;
    }

    /**
     * Prepares multiple entities for get
     *
     * @param Collection $entities
     *
     * @return boolean
     */
<<<<<<< HEAD
    protected function prepareEntitesForGet(Collection $entities)
=======
    protected function prepareEntitesForGet(Collection $entities): bool
>>>>>>> feature/multi
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
<<<<<<< HEAD
    public function getById($id)
    {
        $entity = $this->getRepository()->findById($id);

        $this->prepareEntityForGet($entity);
=======
    public function getById($id): ?AbstractEntity
    {
        $entity = $this->getRepository()->findById($id);

        if ($entity instanceof AbstractEntity) {
            $this->prepareEntityForGet($entity);
        }
>>>>>>> feature/multi

        return $entity;
    }

    /**
<<<<<<< HEAD
     * Gets all entities matching a Criteria
     *
     * @param Criteria $criteria
     *
     * @return Collection
     */
    public function getEntitiesMatching(Criteria $criteria)
    {
        $entities = $this->getRepository()->matching($criteria);
=======
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
>>>>>>> feature/multi

        $this->prepareEntitesForGet($entities);

        return $entities;
    }

    /**
     * Gets all entities matching a Criteria
     *
<<<<<<< HEAD
     * @param Criteria $criteria
     *
     * @return Collection
     */
    public function getOneEntityMatching(Criteria $criteria)
    {
        $entity = $this->getRepository()->matching($criteria)->first();

        $this->prepareEntityForGet($entity);
=======
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
>>>>>>> feature/multi

        return $entity;
    }

    /**
     * Get entities with id in $ids
     *
<<<<<<< HEAD
     * @param array   $ids
     * @param array   $orderBy
     * @param integer $limit
     * @param integer $offset
     *
     * @return Collection
     */
    public function getByIds(array $ids, array $orderBy = null, $limit = null, $offset = null)
    {
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->in('id', $ids));
        $criteria->orderBy($orderBy);
        $criteria->setFirstResult($offset);
        $criteria->setMaxResults($limit);

        return $this->getEntitiesMatching($criteria);
=======
     * @param array $ids
     *
     * @return array
     */
    public function getByIds(array $ids): array
    {

        $entities = $this->getRepository()->findByIds($ids);

        $this->prepareEntitesForGet($entities);

        return $entities;
>>>>>>> feature/multi
    }

    /**
     * Persists an entity
     *
     * @param AbstractEntity $entity
     */
    public function persist(AbstractEntity $entity)
    {
<<<<<<< HEAD
        if($this->prepareEntityForPersist($entity)) {
=======
        if ($this->prepareEntityForPersist($entity)) {
>>>>>>> feature/multi
            $this->getRepository()->persist($entity);
        }

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
<<<<<<< HEAD
     * @return Collection
     */
    public function getAll()
    {
        return $this->getEntitiesMatching(Criteria::create());
=======
     * @return array
     */
    public function getAll(): array
    {
        return $this->getEntitiesBy([]);
>>>>>>> feature/multi
    }

    /**
     * Gets all entities not deleted
     *
<<<<<<< HEAD
     * @return \Doctrine\Common\Collections\Collection
     *
     * @throws \Exception
     */
    public function getAllNotDeleted()
=======
     * @return array
     *
     * @throws \Exception
     */
    public function getAllNotDeleted(): array
>>>>>>> feature/multi
    {
        if (!$this->entityImplements(SoftDeleteInterface::class)) {
            throw new \Exception(sprintf('Entities of class "%s" do not implement interface "%s"', $this->getEntityClassName(), SoftDeleteInterface::class));
        }

<<<<<<< HEAD
        $criteria = Criteria::create();

        $criteria->where(Criteria::expr()->eq('deleted', false));

        return $this->getEntitiesMatching($criteria);
=======
        return $this->getEntitiesBy(['deleted' => false]);
>>>>>>> feature/multi
    }
}
