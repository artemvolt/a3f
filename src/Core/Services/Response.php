<?php

namespace A3F\Core\Services;

use Throwable;

/**
 * class Response
 */
class Response
{
    private bool $isSuccess;
    private array $errors;

    private function __construct(bool $isSuccess, array $errors) {
        $this->isSuccess = $isSuccess;
        $this->errors = $errors;
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
     * @return string
     */
    public function getErrorText():string {
        return $this->errors['error'];
    }

    /**
     * @return bool
     */
    public function isSuccess():bool {
        return $this->isSuccess === true;
    }
}