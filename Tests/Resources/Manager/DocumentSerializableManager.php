<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 11:46
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Resources\Manager;

use Thuata\FrameworkBundle\Manager\AbstractManager;
use Thuata\FrameworkBundle\Repository\AbstractRepository;
use Thuata\FrameworkBundle\Tests\Resources\Entity\DocumentSerializableEntity;
use Thuata\FrameworkBundle\Tests\Resources\Repository\DocumentSerializableRepository;


/**
 * Class DocumentSerializableManager
 *
 * @package   Thuata\FrameworkBundle\Tests\Resources\Manager
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class DocumentSerializableManager extends AbstractManager
{
    /**
     * Returns the class name for the entity
     *
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return DocumentSerializableEntity::class;
    }

    /**
     * Mocks the repository
     *
     * @return AbstractRepository
     */
    protected function getRepository(): AbstractRepository
    {
        return new DocumentSerializableRepository();
    }


}