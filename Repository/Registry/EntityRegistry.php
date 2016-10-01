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

namespace thuata\frameworkbundle\Repository\Registry;

use Thuata\ComponentBundle\Registry\RegistryInterface;
use Thuata\FrameworkBundle\Repository\AbstractRepository;

/**
 * <b>EntityRegistry</b><br>
 * Defines methods for the registries used by repositories.
 *
 * @package thuata\frameworkbundle\Repository\Registry
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
abstract class EntityRegistry implements RegistryInterface
{
    /**
     * @var AbstractRepository
     */
    private $repository;

    /**
     * Sets the repository
     *
     * @param \Thuata\FrameworkBundle\Repository\AbstractRepository $repository
     */
    public function setRepository(AbstractRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets the repository
     *
     * @return \Thuata\FrameworkBundle\Repository\AbstractRepository
     */
    protected function getRepository()
    {
        return $this->repository;
    }
}