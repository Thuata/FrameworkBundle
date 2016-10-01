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

namespace Thuata\FrameworkBundle\Tests\Traits;

/**
 * Trait ReflectionTestTrait
 *
 * @package Thuata\FrameworkBundle\Tests\Traits
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
trait ReflectionTestTrait
{

    /**
     * Invokes a non-accessible method and returns the result
     *
     * @param mixed  $object
     * @param string $methodName
     * @param array  $params
     *
     * @return mixed
     */
    public function invokeMethod($object, $methodName, $params = [])
    {
        $reflectionClass = new \ReflectionClass($object);

        $method = $reflectionClass->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $params);
    }

    /**
     * Returns the value of a non accessible parameter
     *
     * @param mixed  $object
     * @param string $paramName
     *
     * @return mixed
     */
    public function getParameter($object, $paramName)
    {
        $reflectionClass = new \ReflectionClass($object);

        $param = $reflectionClass->getProperty($paramName);
        $param->setAccessible(true);

        return $param->getValue($object);
    }
}