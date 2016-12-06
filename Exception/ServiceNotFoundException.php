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

namespace Thuata\FrameworkBundle\Exception;

/**
 * <b>ServiceNotFoundException</b><br>
 *
 *
 * @package thuata\frameworkbundle\Exception
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class ServiceNotFoundException extends \LogicException
{
    const MESSAGE_FORMAT = 'The service "%s" was found neither as class neither as symfony service id';
    const ERROR_CODE = 500;

    /**
     * InvalidService constructor.
     *
     * @param string $serviceClass
     */
    public function __construct(string $serviceClass)
    {
        parent::__construct(sprintf(self::MESSAGE_FORMAT, $serviceClass), self::ERROR_CODE);
    }
}