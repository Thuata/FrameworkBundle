<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 15:32
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Exception;


/**
 * Class MongoDBConnectionNameNotFoundException
 *
 * @package   Thuata\FrameworkBundle\Exception
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class MongoDBConnectionNameNotFoundException extends \Exception
{
    const MESSAGE_FORMAT = 'Mongo Connection with name "%s" not found in factory.';
    const MESSAGE_DEFAULT = 'No default Mongo Connection found in factory.';
    const ERROR_CODE = 500;

    /**
     * MongoDBConnectionNameNotFoundException constructor.
     *
     * @param string $name
     */
    public function __construct(string $name = null)
    {
        $message = is_null($name) ? self::MESSAGE_DEFAULT : sprintf(self::MESSAGE_FORMAT, $name);
        parent::__construct($message, self::ERROR_CODE);
    }
}