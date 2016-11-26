<?php
/**
 * Created by Enjoy Your Business.
 * Date: 25/11/2016
 * Time: 11:44
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Bridge\Doctrine;

use Doctrine\ORM\Internal\Hydration\ArrayHydrator;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use PDO;
use Symfony\Component\VarDumper\VarDumper;
use Thuata\FrameworkBundle\Entity\AbstractEntity;

/**
 * Class EntityHydrator
 *
 * @package   Thuata\FrameworkBundle\Bridge\Doctrine
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
class EntityHydrator extends ArrayHydrator
{
    const HYDRATOR_MODE = 'ThuataEntityHydrator';

    protected function hydrateAllData()
    {
        $entityClassName = reset($this->_rsm->aliasMap);
        $entity = new $entityClassName();
        $entities = [];
        foreach (parent::hydrateAllData() as $data) {
            $entities[] = $this->hydrateEntity(clone $entity, $data);
        }

        return $entities;
    }

    protected function hydrateEntity(AbstractEntity $entity, array $data)
    {
        $classMetaData = $this->getClassMetadata(get_class($entity));
        foreach ($data as $fieldName => $value) {
            VarDumper::dump($fieldName);
            VarDumper::dump($value);
            if ($classMetaData->hasAssociation($fieldName)) {
                $associationData = $classMetaData->getAssociationMapping($fieldName);
                switch ($associationData['type']) {
                    case ClassMetadataInfo::ONE_TO_ONE:
                    case ClassMetadataInfo::MANY_TO_ONE:
                        $data[$fieldName] = $this->hydrateEntity(new $associationData['targetEntity'](), $value);
                        break;
                    case ClassMetadataInfo::MANY_TO_MANY:
                    case ClassMetadataInfo::ONE_TO_MANY:
                        $entities = [];
                        $targetEntity = new $associationData['targetEntity']();
                        foreach ($value as $associatedEntityData) {
                            $entities[] = $this->hydrateEntity(clone $targetEntity, $associatedEntityData);
                        }
                        $data[$fieldName] = $entities;
                        break;
                    default:
                        throw new \RuntimeException('Unsupported association type');
                }
            }
        }
        die();
//        $entity->populate($data);

        return $entity;
    }
}