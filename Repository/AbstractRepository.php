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

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Persisters\Entity\BasicEntityPersister;
use Thuata\ComponentBundle\Hydrator\ColumnHydrator;
use Thuata\ComponentBundle\Registry\RegistryInterface;
use Thuata\FrameworkBundle\Entity\AbstractEntity;
use Thuata\FrameworkBundle\Exception\InvalidEntityNameException;
use Thuata\FrameworkBundle\Exception\NoEntityNameException;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableTrait;
use Thuata\FrameworkBundle\Repository\Registry\ArrayRegistry;
use Thuata\FrameworkBundle\Repository\Registry\DoctrineRegistry;
use Thuata\FrameworkBundle\Repository\Registry\RegistryFactory;

/**
 * <b>AbstractRepository<b><br>
 * Abstract class for all repositories. Any ENTITY should have a repository attached name from it.<br>
 * The repository will gather entities from Registries. It provides methods to find entities from criteria or ids.<br>
 * The repository are provided by the RepositoryFactory witch is available only from Manager.
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 *
 * @property RepositoryFactory $factory
 */
abstract class AbstractRepository implements FactorableInterface
{
    use FactorableTrait;
    const ENTITY_NAME_CONST_FORMAT = '%s::ENTITY_NAME';

    /**
     * @var array
     */
    private $registries = [];

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @var RegistryFactory
     */
    private $registryFactory;

    /**
     * Gets an entity name from an entity class name if it provides an ENTITY_NAME constant
     *
     * @param string $className
     *
     * @return string
     */
    public static function getEntityNameFromClassName(string $className)
    {
        $entityName = constant(sprintf(self::ENTITY_NAME_CONST_FORMAT, $className));

        if ($entityName === AbstractEntity::ENTITY_NAME or !is_string($entityName)) {
            throw new NoEntityNameException($className);
        }

        return $entityName;
    }

    /**
     * Gets the entity class
     *
     * @return string
     */
    abstract public function getEntityClass(): string;

    /**
     * Sets the entity manager
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->entityManager = $em;
    }

    public function setRegistryFactory(RegistryFactory $factory)
    {
        $this->registryFactory = $factory;
    }

    /**
     * Gets the doctrine connection to use for that entity
     *
     * @return null|string
     */
    public function getConnectionName(): ?string
    {
        return null;
    }

    /**
     * Loads the registries
     */
    public function loadRegistries()
    {
        $registries = $this->registryFactory->getDefaultRegistries();

        foreach ($registries as $registry) {
            $this->addRegistry($registry);
        }
    }

    /**
     * Gets the entity name
     *
     * @return string
     */
    public function getEntityName()
    {
        if (is_null($this->entityName)) {
            $this->entityName = self::getEntityNameFromClassName($this->getEntityClass());
        }

        return $this->entityName;
    }

    /**
     * Adds a new registry at the queue of the list.
     * The registries are parsed from head to queue (FIFO) for read.
     *
     * @param $registryName
     *
     * @return $this
     */
    protected function addRegistry(string $registryName)
    {
        $this->registries[] = $this->registryFactory->getRegistry($registryName, $this->getEntityName());

        return $this;
    }

    /**
     * Gets a new instance
     *
     * @return mixed
     */
    public function getNew()
    {
        $className = $this->getEntityClass();

        $ref = new \ReflectionClass($className);

        return $ref->newInstance();
    }

    /**
     * Persists an entity
     *
     * @param AbstractEntity $entity
     */
    public function persist(AbstractEntity $entity)
    {
        $update = $entity->getId() !== null;

        for ($i = count($this->registries) - 1; $i >= 0; $i--) {
            /** @var RegistryInterface $registry */
            $registry = $this->registries[ $i ];
            if ($update) {
                $registry->update($entity->getId(), $entity);
            } else {
                $registry->add($entity->getId(), $entity);
            }
        }
    }

    /**
     * Removes an entity
     *
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity)
    {
        for ($i = count($this->registries) - 1; $i >= 0; $i--) {
            /** @var RegistryInterface $registry */
            $registry = $this->registries[ $i ];
            $registry->remove($entity->getId());
        }
    }

    /**
     * Finds an entity by its id
     *
     * @param int $id
     *
     * @return AbstractEntity|null
     */
    public function findById(int $id)
    {
        $entity = null;

        for ($i = 0; $i < count($this->registries); $i++) {
            /** @var RegistryInterface $registry */
            $registry = $this->registries[ $i ];
            $entity = $registry->findByKey($id);

            if ($entity instanceof AbstractEntity) {
                $this->updateRegistries([$entity], $i - 1);
                break;
            }
        }

        return $entity;
    }

    /**
     * Finds a list of entities by their ids
     *
     * @param array $ids
     *
     * @return array
     */
    public function findByIds(array $ids)
    {
        $entities = [];

        for ($i = 0; $i < count($this->registries); $i++) {
            /** @var RegistryInterface $registry */
            $registry = $this->registries[ $i ];
            $found = $registry->findByKeys($ids);
            $entities = array_merge($entities, $found);

            $this->updateRegistries($found, $i - 1);

            if (count($entities) === count($ids)) {
                break;
            }
        }

        return $entities;
    }

    /**
     * Finds entities by criteria
     *
     * @param array $criteria
     *
     * @param array $orders
     * @param null  $limit
     * @param null  $offset
     *
     * @return array
     */
    public function findBy(array $criteria = [], array $orders = [], $limit = null, $offset = null): array
    {
        $queryCriteria = Criteria::create();

        foreach ($criteria as $prop => $value) {
            $queryCriteria->andWhere(Criteria::expr()->eq($prop, $value));
        }

        $queryCriteria->orderBy($orders);

        if ($limit !== null) {
            $queryCriteria->setMaxResults($limit);
        }

        if ($offset !== null) {
            $queryCriteria->setFirstResult($offset);
        }

        return $this->matching($queryCriteria);
    }

    /**
     * Finds one entity from criteria
     *
     * @param array $criteria
     * @param array $orders
     * @param null  $offset
     *
     * @return AbstractEntity
     */
    public function findOneBy(array $criteria = [], array $orders = [], $offset = null): ?AbstractEntity
    {
        $array = $this->findBy($criteria, $orders, 1, $offset);

        return array_shift($array);
    }

    /**
     * Gets all entities matching query criteria
     *
     * @param Criteria $criteria
     *
     * @return array
     */
    public function matching(Criteria $criteria): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('e.id')
            ->from($this->getEntityName(), 'e');

        $queryBuilder->addCriteria($criteria);

        $ids = $queryBuilder->getQuery()->getResult(ColumnHydrator::HYDRATOR_MODE);

        if (count($ids) === 0) {
            return [];
        }

        return $this->findByIds($ids);
    }

    /**
     * Gets the doctrine's entity repository for the entity
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        $repository = $this->entityManager->getRepository($this->getEntityName());

        if (!($repository instanceof EntityRepository)) {
            throw new InvalidEntityNameException($this->getEntityName(), $this->getEntityClass());
        }

        return $repository;
    }

    /**
     * Updates the registries
     *
     * @param array $entities
     * @param int   $from
     */
    private function updateRegistries($entities, $from)
    {
        if (count($entities) >= 0) {
            for ($j = $from; $j >= 0; $j--) {
                /** @var RegistryInterface $registry */
                $registry = $this->registries[ $j ];
                /** @var AbstractEntity $entity */
                foreach ($entities as $entity) {
                    $registry->add($entity->getId(), $entity);
                }
            }
        }
    }
}
