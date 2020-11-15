<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Model\Query;

use Illuminate\Pagination\LengthAwarePaginator as IlluminatePaginator;

/**
 * Class PaginatedCollection
 *
 * @package Ares\Framework\Model\Query
 */
class PaginatedCollection extends IlluminatePaginator
{
    /**
     * Accumulate the Items and sets them
     *
     * @param $items
     *
     * @return $this
     */
    public function setItems($items): self
    {
        $this->items = accumulate($items);

        return $this;
    }
}
