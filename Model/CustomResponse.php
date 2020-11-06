<?php
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Model;

use Ares\Framework\Interfaces\CustomResponseInterface;

/**
 * Class Response
 *
 * @package Ares\Framework\Model
 */
class CustomResponse implements CustomResponseInterface
{
    /**
     * @var string
     */
    private string $status = '';

    /**
     * @var int
     */
    private int $code = 0;

    /**
     * @var string
     */
    private string $exception = '';

    /**
     * @var array
     */
    private array $errors = [];

    /**
     * @var mixed
     */
    private $data;

    /**
     * Returns status as json.
     *
     * @return string
     */
    public function getJson(): string
    {
        $response = [
            'status' => $this->getStatus(),
            'code' => $this->getCode(),
            'exception' => $this->getException(),
            'errors' => $this->getErrors(),
            'data' => $this->getData()
        ];

        return json_encode($response);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        if (!$this->status) {
            return __('ok');
        }

        return $this->status;
    }

    /**
     * @param string $status
     * @return CustomResponseInterface
     */
    public function setStatus(string $status): CustomResponseInterface
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        if (!$this->code) {
            return 200;
        }

        return $this->code;
    }

    /**
     * @param int $code
     * @return CustomResponseInterface
     */
    public function setCode(int $code): CustomResponseInterface
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getException(): string
    {
        if (!$this->exception) {
            return '';
        }

        return $this->exception;
    }

    /**
     * @param string $exception
     * @return CustomResponseInterface
     */
    public function setException(string $exception): CustomResponseInterface
    {
        $this->exception = $exception;
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        if (!$this->errors) {
            return [];
        }

        return $this->errors;
    }

    /**
     * @param array $error
     * @return CustomResponseInterface
     */
    public function addError(array $error): CustomResponseInterface
    {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (!$this->data) {
            return [];
        }

        return $this->data;
    }

    /**
     * @param mixed $data
     * @return CustomResponseInterface
     */
    public function setData($data): CustomResponseInterface
    {
        $this->data = $data;
        return $this;
    }
}