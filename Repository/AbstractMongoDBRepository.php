<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/11/2016
 * Time: 10:32
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Repository;

use MongoDB\Collection;
use MongoDB\Driver\Cursor;
use Thuata\FrameworkBundle\Repository\Registry\MongoDBAwareInterface;


/**
 * Class AbstractDoctrineRepository
 *
 * @package   Thuata\FrameworkBundle\Repository
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
abstract class AbstractMongoDBRepository extends AbstractRepository implements MongoDBAwareInterface
{
    /**
     * @var Collection
     */
    private $collection;


    public function setMongoDBCollection(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Loads the registries
     */
    public function loadRegistries()
    {
        $this->addRegistry('array')
            ->addRegistry('mongodb');
    }

    /**
     * Finds entities by criteria
     *
     * @param array $criteria
     *
     * @param array $orders
     * @param null  $limit
     * @param null  $offset
     *
     * @return array
     */
    public function findBy(array $criteria = [], array $orders = [], $limit = null, $offset = null): array
    {
        /** @var Cursor $cursor */
        $cursor = $this->collection->find($criteria);

        if ($orders) {
            foreach ($orders as $field => &$dir) {
                if ($dir === 'ASC') {
                    $dir = 1;
                } elseif ($dir === 'DESC') {
                    $dir = -1;
                }

            }
            $cursor->sort($orders);
        }

        if ($limit !== null) {
            $cursor->limit($limit);
        }

        if ($offset !== null) {
            $cursor->skip($offset);
        }

        return iterator_to_array($cursor);
    }
}