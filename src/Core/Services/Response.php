<?php

namespace A3F\Core\Services;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * class Response
 */
class Response
{
    private bool $isSuccess;
    private array $validateErrors;
    private array $errors;

    private function __construct(bool $isSuccess, array $errors, array $validateErrors = []) {
        $this->isSuccess = $isSuccess;
        $this->errors = $errors;
        $this->validateErrors = $validateErrors;
    }

    /**
     * @return static
     */
    public static function success():static {
        return new static(true, []);
    }

    public static function error(Throwable $exception):static {
        return new static(false, [
            'error' => $exception->getMessage()
        ]);
    }

    /**
     * @param ConstraintViolationListInterface $errors
     * @return static
     */
    public static function validateErrors(ConstraintViolationListInterface $errors):static {
        return new static(false,
            [],
            [$errors[0]->getMessage()]
        );
    }

    /**
     * @return string
     */
    public function getErrorText():string {
        if ( ! empty($this->validateErrors)) {
            return implode(". ", $this->validateErrors);
        }
        return $this->errors['error'];
    }

    /**
     * @return bool
     */
    public function isSuccess():bool {
        return $this->isSuccess === true;
    }
}