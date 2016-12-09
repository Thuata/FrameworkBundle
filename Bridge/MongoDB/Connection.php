<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 15:24
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Bridge\MongoDB;

use MongoDB\Client;
use MongoDB\Database;

/**
 * Class Connection
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class Connection
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var integer
     */
    private $port;

    /**
     * @var string
     */
    private $dbName;

    public function __construct(string $host, int $port, string $dbName)
    {
        $this->host = $host;
        $this->port = $port;
        $this->dbName = $dbName;
    }

    /**
     * Gets host
     *
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * Sets host
     *
     * @param string $host
     *
     * @return Connection
     */
    public function setHost(string $host): Connection
    {
        $this->host = $host;

        return $this;
    }

    /**
     * Gets port
     *
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * Sets port
     *
     * @param int $port
     *
     * @return Connection
     */
    public function setPort(int $port): Connection
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Gets dbName
     *
     * @return string
     */
    public function getDbName(): string
    {
        return $this->dbName;
    }

    /**
     * Sets dbName
     *
     * @param string $dbName
     *
     * @return Connection
     */
    public function setDbName(string $dbName): Connection
    {
        $this->dbName = $dbName;

        return $this;
    }

    /**
     * Gets the connection string
     *
     * @return string
     */
    public function getConnectionString()
    {
        return sprintf('mongodb://%s:%d', $this->host, $this->port);
    }

    /**
     * Gets the client
     *
     * @return Client
     */
    public function getMongoClient(): Client
    {
        return new Client($this->getConnectionString());
    }

    /**
     * Gets the database
     *
     * @return Database
     */
    public function getMongoDatabase(): Database
    {
        return $this->getMongoClient()->selectDatabase($this->dbName);
    }

    /**
     * Converts to string. Returns the connection string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getConnectionString();
    }
}