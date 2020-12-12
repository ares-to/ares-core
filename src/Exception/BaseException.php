<?php declare(strict_types=1);
/**
 * @copyright Copyright (c) Ares (https://www.ares.to)
 *
 * @see LICENSE (MIT)
 */

namespace Ares\Framework\Exception;

use Throwable;

/**
 * Class BaseException
 *
 * @package Ares\Framework\Exception
 */
abstract class BaseException extends \Exception
{
    /**
     * BaseException constructor.
     *
     * @param string         $message
     * @param int            $customCode
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        protected $message = "",
        protected $customCode = 1,
        protected $code = 200,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @var array
     */
    private array $errors = [];

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     */
    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return int|string
     */
    public function getCustomCode(): int|string
    {
        return $this->customCode;
    }
}
