<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 11:51
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Resources\Manager;
use Thuata\FrameworkBundle\Manager\AbstractManager;
use Thuata\FrameworkBundle\Tests\Document\TestDocument;


/**
 * Class TestDocumentManager
 *
 * @package   Thuata\FrameworkBundle\Tests\Resources\Manager
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class TestDocumentManager extends AbstractManager
{

    /**
     * Returns the class name for the entity
     *
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return TestDocument::class;
    }
}