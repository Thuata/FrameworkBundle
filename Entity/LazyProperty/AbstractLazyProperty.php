<?php
/**
 * Created by Enjoy Your Business.
 * Date: 06/09/2016
 * Time: 14:59
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Entity\LazyProperty;

/**
 * Class AbstractLazyProperty
 *
 * @package   Thuata\FrameworkBundle\Entity\LazyProperty
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 */
abstract class AbstractLazyProperty implements LazyPropertyInterface
{
    /**
     * @var bool
     */
    protected $initialized = false;

    /**
     * Is the object already initialized ?
     *
     * @return bool
     */
    public function isInitialized()
    {
        return $this->initialized;
    }

    /**
     * Do the initialization
     *
     * @return void
     */
    abstract protected function doInitialize();

    /**
     * Do the reset object
     *
     * @return void
     */
    abstract protected function doReset();

    /**
     * Do the get datas
     *
     * @return mixed
     */
    abstract protected function doGetData();

    /**
     * Initialize object
     *
     * @param bool $force
     */
    protected function initialize($force = false)
    {
        if(!$this->isInitialized() || $force){
            $this->doReset();
            $this->doInitialize();
            $this->initialized = true;
        }
    }

    /**
     * Reset object state
     */
    public function reset()
    {
        $this->doReset();
        $this->initialized = false;
    }

    /**
     * Get data of LazyObject
     *
     * @param bool $forceRetrieve
     *
     * @return mixed
     */
    public function getData($forceRetrieve = false)
    {
        $this->initialize($forceRetrieve);
        return $this->doGetData();
    }
}