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
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Internal\Hydration\ArrayHydrator;
use Symfony\Component\VarDumper\VarDumper;
use Thuata\FrameworkBundle\Bridge\Doctrine\EntityHydrator;

/**
 * <b>DoctrineRegistry</b><br>
 * Defines a registry to get data from database using doctrine. Slower but data is persistent
 *
 * @package Thuata\FrameworkBundle\Repository\Registry
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class DoctrineRegistry extends EntityRegistry
{
    const NAME = 'doctrine';

    /**
     * {@inheritdoc}
     */
    public function findByKey($key)
    {
        $results = $this->findByKeys([$key]);

        return array_shift($results);
    }

    /**
     * {@inheritdoc}
     */
    public function findByKeys(array $keys)
    {
        $qb = $this->getEntityRepository()->createQueryBuilder('e');
        $result = $qb->select('e')
            ->where('e.id in (:keys)')
            ->setParameter('keys', $keys)
            ->getQuery()->getResult();

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $data)
    {
        $this->getEntityManager()->persist($data);
        $this->getEntityManager()->merge($data);
        $this->getEntityManager()->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        $entity = $this->findByKey($key);

        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->getUnitOfWork()->commit($entity);
    }

    /**
     * {@inheritdoc}
     */
    public function update($key, $data)
    {
        $this->add($key, $data);
    }
}