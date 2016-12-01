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

namespace Thuata\FrameworkBundle\Manager\Interfaces;

use Thuata\FrameworkBundle\Manager\AbstractManager;

/**
 * <b>ManagerAccessableInterface</b><br>
 * Provides a setManager method for any class that should access to a manager
 *
 * @package Thuata\FrameworkBundle\Manager\Interfaces
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
interface ManagerAccessableInterface
{
    /**
     * Sets the accessible manager
     * 
     * @param AbstractManager $manager
     * 
     * @return ManagerAccessableInterface
     */
    public function setManager(AbstractManager $manager);
}
