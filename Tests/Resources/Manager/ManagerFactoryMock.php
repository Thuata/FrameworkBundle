<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 14:10
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Resources\Manager;
use Thuata\FrameworkBundle\Manager\ManagerFactory;


/**
 * Class ManagerFactoryMock
 *
 * @package   Thuata\FrameworkBundle\Tests\Resources\Manager
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class ManagerFactoryMock extends ManagerFactory
{
    /**
     * {@inheritdoc}
     */
    public function getFactorableInstance(string $factorableClassName)
    {
        return new $factorableClassName();
    }

}