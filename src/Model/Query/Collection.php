<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Model\Query;

use Illuminate\Support\Collection as IlluminateCollection;

/**
 * Class Collection
 *
 * @package Ares\Framework\Model\Query
 */
class Collection extends IlluminateCollection
{
    /**
     * Returns array of collection value by key.
     *
     * @param mixed $key
     * @param null  $default
     * @return array|mixed
     */
    public function get($key, $default = null)
    {
        $result = array_column($this->items, $key);

        if (!$result) {
            return value($default);
        }

        return $result;
    }
}
