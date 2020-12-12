<?php
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Interfaces;

/**
 * Interface CustomResponseCodeInterface
 *
 * @package Ares\Framework\Interfaces
 */
interface CustomResponseCodeInterface
{
    /** @var int */
    public const RESPONSE_UNKNOWN_ERROR = 1;

    /** @var int */
    public const RESPONSE_THROTTLE_ERROR = 429;

    /** @var int */
    public const RESPONSE_NOT_ALLOWED = 401;
}
