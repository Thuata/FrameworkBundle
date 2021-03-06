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

use Thuata\FrameworkBundle\Factory\AbstractFactory;
use Thuata\FrameworkBundle\Factory\Factorable\FactorableInterface;
use Thuata\FrameworkBundle\Manager\AbstractManager;
use Thuata\ComponentBundle\Registry\RegistryableTrait;
use Thuata\FrameworkBundle\Repository\RepositoryFactory;

/**
 * <b>ManagerFactory</b><br>
 * Factory to instantiate managers for entities
 *
 * @package Thuata\FrameworkBundle\Manager
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class ManagerFactory extends AbstractFactory
{
    use RegistryableTrait;

    /**
     * {@inheritdoc}
     */
    protected function injectDependancies(FactorableInterface $factorable)
    {
        /** @var RepositoryFactory $repositoryFactory */
        $repositoryFactory = $this->getContainer()->get('thuata_framework.repositoryfactory');
        /** @var AbstractManager $factorable */
        $factorable->setRepositoryFactory($repositoryFactory);
        $factorable->setManagerFactory($this);
    }
}
