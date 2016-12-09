<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 15:28
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Bridge\MongoDB;

use Thuata\ComponentBundle\Singleton\SingletonableTrait;
use Thuata\ComponentBundle\Singleton\SingletonInterface;
use Thuata\FrameworkBundle\Exception\MongoDBConnectionNameNotFoundException;


/**
 * Class ConnectionFactory
 *
 * @package   Thuata\FrameworkBundle\Bridge\MongoDb
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 *
 * @method static ConnectionFactory getInstance(): ConnectionFactory
 */
class ConnectionFactory implements SingletonInterface
{
    use SingletonableTrait;

    /**
     * @var array
     */
    private $registry = [];

    /**
     * @var Connection
     */
    private $defaultConnection;

    /**
     * Adds a connection
     *
     * @param string     $name
     * @param Connection $connection
     *
     * @return ConnectionFactory
     */
    public function addConnection(string $name = null, Connection $connection = null): self
    {
        if (is_null($name)) {
            $this->defaultConnection = $connection;
        } else {
            $this->registry[$name] = $connection;
        }

        return $this;
    }

    /**
     * Gets a connection
     *
     * @param string $name
     *
     * @return Connection
     *
     * @throws MongoDBConnectionNameNotFoundException
     */
    public function getConnection(string $name = null): Connection
    {
        if (is_null($name) and !is_null($this->defaultConnection)) {
            return $this->defaultConnection;
        }

        if (is_null($name) or !array_key_exists($name, $this->registry)) {
            throw new MongoDBConnectionNameNotFoundException($name);
        }

        return $this->registry[$name];
    }
}