<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 14:12
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Resources\Repository;
use Thuata\FrameworkBundle\Repository\AbstractRepository;
use Thuata\FrameworkBundle\Tests\Resources\Entity\DocumentSerializableEntity;


/**
 * Class DocumentSerializableRepository
 *
 * @package   Thuata\FrameworkBundle\Tests\Resources\Repository
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class DocumentSerializableRepository extends AbstractRepository
{

    /**
     * Gets the entity class
     *
     * @return string
     */
    public function getEntityClass(): string
    {
        return DocumentSerializableEntity::class;
    }
}