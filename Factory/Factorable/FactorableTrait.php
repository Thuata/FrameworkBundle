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

namespace Thuata\FrameworkBundle\Factory\Factorable;

use Thuata\FrameworkBundle\Factory\FactoryInterface;

/**
 * <b>FactorableTrait</b><br>
 * Defines thez methods signed in FactorableInterface
 *
 * @package Thuata\FrameworkBundle\Factory\Factorable
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
trait FactorableTrait
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * Sets the factory that instanciated that factorable
     * 
     * @param FactoryInterface $factory
     * 
     * @return FactorableInterface
     */
    public function setFactory(FactoryInterface $factory)
    {
        $this->factory = $factory;
        
        return $this;
    }
    
    /**
     * Gets the factory that instanciated that factorable
     * 
     * @return FactoryInterface
     */
    protected function getFactory()
    {
        return $this->factory;
    }
}
