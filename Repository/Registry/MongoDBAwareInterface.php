<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/11/2016
 * Time: 10:59
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Repository\Registry;

use MongoDB\Collection;


/**
 * Interface MongoDBAwareInterface
 *
 * @package   Thuata\FrameworkBundle\Repository\Registry
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
interface MongoDBAwareInterface
{
    public function setMongoDBCollection(Collection $collection);
}