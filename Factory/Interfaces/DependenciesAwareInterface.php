<?php
/**
 * Created by Enjoy Your Business.
 * Date: 10/11/2016
 * Time: 10:56
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Factory\Interfaces;

/**
 * Interface DependenciesAwareInterface
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
interface DependenciesAwareInterface
{
    /**
     * Gets the dependencies needed by the factorable. MUST return a hash with properties to set as key
     * and service keys as value
     *
     * @return array
     */
    public static function getDependencies();
}