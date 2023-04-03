<?php

namespace App\Packages\Finance\Exceptions;

class RequestDataException extends \Exception {

    /**
     * @param $message
     * @param $code
     * @param \Throwable|null $previous
     */
    public function __construct($message, $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
