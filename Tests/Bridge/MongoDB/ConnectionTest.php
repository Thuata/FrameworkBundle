<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 16:01
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Bridge\MongoDB;

use Thuata\FrameworkBundle\Bridge\MongoDB\Connection;
use Thuata\FrameworkBundle\Bridge\MongoDB\ConnectionFactory;

/**
 * Class Connection
 *
 * @package   Thuata\FrameworkBundle\Tests\Bridge\MongoDb
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testConnection()
    {
        $connection = new Connection('127.0.0.1', 1234, 'test_db');

        $this->assertEquals('127.0.0.1', $connection->getHost());
        $this->assertEquals(1234, $connection->getPort());
        $this->assertEquals('test_db', $connection->getDbName());
        $this->assertEquals('mongodb://127.0.0.1:1234', $connection->getConnectionString());
        $this->assertEquals('mongodb://127.0.0.1:1234', (string) $connection);
    }

    public function testFactory()
    {
        $connectionDefault = new Connection('127.0.0.1', 1234, 'test_db');
        $connectionOther = new Connection('127.0.0.2', 1234, 'test_db_2');

        ConnectionFactory::getInstance()->addConnection(null, $connectionDefault);
        ConnectionFactory::getInstance()->addConnection('other', $connectionOther);

        $connection = ConnectionFactory::getInstance()->getConnection();

        $this->assertEquals('127.0.0.1', $connection->getHost());
        $this->assertEquals(1234, $connection->getPort());
        $this->assertEquals('test_db', $connection->getDbName());
        $this->assertEquals('mongodb://127.0.0.1:1234', $connection->getConnectionString());
        $this->assertEquals('mongodb://127.0.0.1:1234', (string) $connection);

        $connection = ConnectionFactory::getInstance()->getConnection('other');

        $this->assertEquals('127.0.0.2', $connection->getHost());
        $this->assertEquals(1234, $connection->getPort());
        $this->assertEquals('test_db_2', $connection->getDbName());
        $this->assertEquals('mongodb://127.0.0.2:1234', $connection->getConnectionString());
        $this->assertEquals('mongodb://127.0.0.2:1234', (string) $connection);
    }

    /**
     * @expectedException \Thuata\FrameworkBundle\Exception\MongoDBConnectionNameNotFoundException
     * @expectedExceptionMessage No default Mongo Connection found in factory.
     */
    public function testFactoryNoDefault()
    {
        ConnectionFactory::getInstance()->addConnection(null, null);
        ConnectionFactory::getInstance()->getConnection();
    }

    /**
     * @expectedException \Thuata\FrameworkBundle\Exception\MongoDBConnectionNameNotFoundException
     * @expectedExceptionMessage Mongo Connection with name "foo" not found in factory.
     */
    public function testFactoryNoName()
    {
        ConnectionFactory::getInstance()->getConnection('foo');
    }
}