<?php
/**
 * Created by Enjoy Your Business.
 * Date: 13/12/2016
 * Time: 09:14
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Manager;
use Thuata\FrameworkBundle\Tests\AbstractKernelTestCase;
use Thuata\FrameworkTestBundle\Entity\ValidEntity;
use Thuata\FrameworkTestBundle\Manager\ValidEntityManager;


/**
 * Class ManagerTest
 *
 * @package   Thuata\FrameworkBundle\Tests\Manager
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class ManagerTest extends AbstractKernelTestCase
{
    public function testManager()
    {
        self::bootKernel();

        /** @var ValidEntityManager $manager */
        $manager = self::$kernel->getContainer()->get('thuata_framework.managerfactory')->getFactorableInstance(ValidEntityManager::class);

        $this->assertInstanceOf(ValidEntityManager::class, $manager);
    }

    public function testNewEntity()
    {
        self::bootKernel();

        /** @var ValidEntityManager $manager */
        $manager = self::$kernel->getContainer()->get('thuata_framework.managerfactory')->getFactorableInstance(ValidEntityManager::class);

        $this->assertInstanceOf(ValidEntity::class, $manager->getNew());
    }
}