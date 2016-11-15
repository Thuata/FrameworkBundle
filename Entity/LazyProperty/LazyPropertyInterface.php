<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/11/2016
 * Time: 10:04
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Entity\LazyProperty;


/**
 * Interface LazyPropertyInterface
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
interface LazyPropertyInterface
{
    /**
     * Reset the lazy object
     *
     * @return void
     */
    public function reset();
}