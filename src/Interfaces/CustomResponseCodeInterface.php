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
    public const RESPONSE_OK = 200;

    public const RESPONSE_SERVER_ERROR = 500;

    /** @var int */
    public const RESPONSE_RATE_LIMIT_ERROR = 429;
}
