<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Factory;

use Ares\Framework\Model\Query\DataObjectManager;
use Illuminate\Database\Capsule\Manager;

/**
 * Class DataObjectManagerFactory
 *
 * @package Ares\Framework\Factory
 */
class DataObjectManagerFactory
{
    /**
     * Creates new DataObject instance.
     *
     * @param string $entity
     * @return DataObjectManager
     */
    public function create(string $entity): DataObjectManager
    {
        $table = $entity::TABLE;
        $manager = Manager::table($table);

        $dataObjectManager = new DataObjectManager(
            $manager->getConnection(),
            $manager->getGrammar(),
            $manager->getProcessor()
        );

        $dataObjectManager->from($table);
        $dataObjectManager->setEntity($entity);

        return $dataObjectManager;
    }
}
