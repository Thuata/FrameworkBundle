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

use Thuata\ComponentBundle\Registry\RegistryInterface;

/**
 * <b>ArrayRegistry</b><br>
 * Defines a registry being an array. Data is stored an retrieved faster but disapear at the end of the execution.
 *
 * @package thuata\frameworkbundle\Repository\Registry
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class ArrayRegistry implements RegistryInterface
{
    const NAME = 'array';

    /**
     * @var array
     */
    private $registry = [];

    /**
     * {@inheritdoc}
     */
    public function findByKey($key)
    {
        if (array_key_exists($key, $this->registry)) {
            return $this->registry[ $key ];
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function findByKeys(array $keys)
    {
        return array_values(array_intersect_key($this->registry, array_flip($keys)));
    }

    /**
     * {@inheritdoc}
     */
    public function add($key, $data)
    {
        $this->registry[ $key ] = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        unset($this->registry[ $key ]);
    }

    /**
     * {@inheritdoc}
     */
    public function update($key, $data)
    {
        $this->add($key, $data);
    }
}