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
 * <b>InvalidEntityNameException</b><br>
 * Thrown when an entity does not provide a valid entity name in its ENTITY_NAME constant
 *
 * @package Thuata\FrameworkBundle\Exception
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
class InvalidEntityNameException extends \LogicException
{
    const MESSAGE_FORMAT = '%s, defined in %s::ENTITY_NAME constant, is not a valid entity name and entity repository can\'t be found in doctrine.';
    const ERROR_CODE = 500;

    /**
     * NoEntityNameException constructor.
     *
     * @param string $entityName
     * @param string $entityClassName
     */
    public function __construct(string $entityName, string $entityClassName)
    {
        parent::__construct(sprintf(self::MESSAGE_FORMAT, $entityName, $entityClassName), self::ERROR_CODE, null);
    }
}