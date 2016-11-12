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

namespace Thuata\FrameworkBundle\Repository\Registry;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * <b>DoctrineRegistry</b><br>
 * Defines a registry to get data from database using doctrine. Slower but data is persistent
 *
 * @package Thuata\FrameworkBundle\Repository\Registry
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class DoctrineRegistry extends EntityRegistry implements EntityManagerAwareInterface
{
<<<<<<< HEAD
=======
    const NAME = 'doctrine';

>>>>>>> feature/multi
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
<<<<<<< HEAD
     * @var EntityRepository
     */
    private $entityRepository;

    /**
=======
>>>>>>> feature/multi
     * Sets the entity manager
     *
     * @param  \Doctrine\ORM\EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
<<<<<<< HEAD
     * Gets the entity repository
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getEntityRepository()
    {
        if (is_null($this->entityRepository)) {
            $this->entityRepository = $this->getRepository()->getEntityRepository();
        }

        return $this->entityRepository;
    }

    /**
=======
>>>>>>> feature/multi
     * {@inheritdoc}
     */
    public function findByKey($key)
    {
        return $this->getEntityRepository()->find($key);
    }

    /**
     * {@inheritdoc}
     */
    public function findByKeys(array $keys)
    {
        return $this->getEntityRepository()->findBy(['id' => $keys]);
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $data)
    {
        $this->entityManager->persist($data);
        $this->entityManager->getUnitOfWork()->commit($data);
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $entity = $this->findByKey($key);

        $this->entityManager->remove($entity);
        $this->entityManager->getUnitOfWork()->commit($entity);
        $this->entityManager->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function update($key, $data)
    {
        $this->add($key, $data);
        $this->entityManager->getUnitOfWork()->commit($data);
    }
}