<?php declare(strict_types=1);
/**
 * Ares (https://ares.to)
 *
 * @license https://gitlab.com/arescms/ares-backend/LICENSE (MIT License)
 */

namespace Ares\Framework\Service;

use Ares\Framework\Exception\ValidationException;
use Rakit\Validation\Validator;

/**
 * Class ValidatorService
 *
 * @package Ares\Framework\Service
 */
class ValidationService
{
    /**
     * @var Validator
     */
    private Validator $validator;

    /**
     * @var array $errors
     */
    private array $errors = [];

    /**
     * ValidationService constructor.
     *
     * @param Validator $validator
     */
    public function __construct(
        Validator $validator
    ) {
        $this->validator = $validator;
    }

    /**
     * Validates the given data and returns an Exception if Validator fails
     *
     * @param       $data
     * @param array $rules
     *
     * @return void
     * @throws ValidationException
     */
    public function validate($data, array $rules): void
    {
        if ($data === null || empty($rules)) {
           throw new ValidationException(__('Please provide a right data set'));
        }

        $validator = $this->validator->make($data, $rules);
        $validator->validate();

        if ($validator->fails()) {
            $fields = $validator->errors()->toArray();

            $errors = [];

            foreach ($fields as $key => $messages) {
                foreach ($messages as $message) {
                    $errors[] = [
                        'field' => $key,
                        'message' => __($message, [ucfirst($key)])
                    ];
                }
            }

            $this->setErrors($errors);

            $validationException = new ValidationException('', 422);
            $validationException->setErrors($this->getErrors());

            throw $validationException;
        }
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param $error
     */
    public function setErrors($error): void
    {
        $this->errors = $error;
    }
}
