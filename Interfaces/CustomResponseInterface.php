<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Interfaces;

/**
 * Interface ResponseInterface
 *
 * @package Ares\Framework\Interfaces
 */
interface CustomResponseInterface
{
    /**
     * @return string
     */
    public function getJson(): string;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @param string $status
     * @return CustomResponseInterface
     */
    public function setStatus(string $status): CustomResponseInterface;

    /**
     * @return int
     */
    public function getCode(): int;

    /**
     * @param int $code
     * @return CustomResponseInterface
     */
    public function setCode(int $code): CustomResponseInterface;

    /**
     * @return string
     */
    public function getException(): string;

    /**
     * @param string $exception
     * @return CustomResponseInterface
     */
    public function setException(string $exception): CustomResponseInterface;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @param array $error
     * @return CustomResponseInterface
     */
    public function addError(array $error): CustomResponseInterface;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @param mixed $data
     * @return CustomResponseInterface
     */
    public function setData($data): CustomResponseInterface;
}
