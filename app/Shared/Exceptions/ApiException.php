<?php

namespace App\Shared\Exceptions;

use Exception;

class ApiException extends Exception
{
    public function __construct(
        string $message,
        public int $status = 400,
        public ?array $errors = null
    ) {
        parent::__construct($message, $status);
    }
}
