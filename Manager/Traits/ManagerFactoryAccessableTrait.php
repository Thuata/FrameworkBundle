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

namespace Thuata\FrameworkBundle\Manager\Traits;

use Thuata\FrameworkBundle\Manager\ManagerFactory;

/**
 * <b>ManagerFactoryAccessableTrait</b><br>
 * Defines the methods from ManagerFactoryAccessableInterface
 *
 * @package Thuata\FrameworkBundle\Manager\Traits
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
trait ManagerFactoryAccessableTrait
{
    /**
     *
     * @var ManagerFactory
     */
    private $managerFactory;
   
    /**
     * Sets the Manager
     * 
     * @param ManagerFactory $managerFactory
     *
     * @return \Thuata\FrameworkBundle\Manager\Interfaces\ManagerFactoryAccessableInterface
     */
    public function setManagerFactory(ManagerFactory $managerFactory)
    {
        $this->managerFactory = $managerFactory;
        
        return $this;
    }

    /**
     * Gets the manager
     * 
     * @return ManagerFactory
     */
    protected function getManagerFactory()
    {
        return $this->managerFactory;
    }
}
