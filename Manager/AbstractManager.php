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

use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableTrait;
use Thuata\FrameworkBundle\Manager\Interfaces\ManagerFactoryAccessableInterface;
use Thuata\FrameworkBundle\Manager\Traits\ManagerFactoryAccessableTrait;
use Thuata\FrameworkBundle\Repository\Interfaces\RepositoryFactoryAccessableInterface;
use Thuata\FrameworkBundle\Entity\Interfaces\TimestampableInterface;
use Thuata\FrameworkBundle\Entity\AbstractEntity;
use Doctrine\Common\Collections\Collection;
use \Doctrine\Common\Collections\Criteria;
use DateTime;
use Thuata\FrameworkBundle\Repository\Traits\RepositoryFactoryAccessableTrait;

/**
 * Description of AbstractManager
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
abstract class AbstractManager implements FactorableInterface, ManagerFactoryAccessableInterface, RepositoryFactoryAccessableInterface
{

    use FactorableTrait,
        ManagerFactoryAccessableTrait,
        RepositoryFactoryAccessableTrait;

    /**
     * Returns the class name for the entity
     *
     * @return string
     */
    abstract protected function getEntityClassName();

    /**
     * Gets the repository corresponding to the managed entity
     *
     * @return \Thuata\FrameworkBundle\Repository\AbstractRepository
     */
    protected function getRepository()
    {
        return $this->getRepositoryFactory()->getRepositoryForEntityClassName($this->getEntityClassName());
    }

    /**
     * Gets a new intance of an entity
     *
     * @return AbstractEntity
     */
    public function getNew()
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
    protected function prepareEntityForNew(AbstractEntity $entity)
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
    protected function prepareEntityForGet(AbstractEntity $entity)
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
    protected function prepareEntityForPersist(AbstractEntity $entity)
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
    protected function prepareEntityForRemove(AbstractEntity $entity)
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
    protected function prepareEntitesForGet(Collection $entities)
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
    public function getById($id)
    {
        $entity = $this->getRepository()->find($id);

        $this->prepareEntityForGet($entity);

        return $entity;
    }

    /**
     * Gets all entities matching a Criteria
     *
     * @param Criteria $criteria
     *
     * @return Collection
     */
    public function getEntitiesMatching(Criteria $criteria)
    {
        $entities = $this->getRepository()->matching($criteria);

        $this->prepareEntitesForGet($entities);

        return $entities;
    }

    /**
     * Get entities with id in $ids
     *
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
    }

    /**
     * Persists an entity
     *
     * @param AbstractEntity $entity
     */
    public function persist(AbstractEntity $entity)
    {
        if($this->prepareEntityForPersist($entity)) {
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
        if($this->prepareEntityForRemove($entity)) {
            $this->getRepository()->remove($entity);
        }
    }
}
