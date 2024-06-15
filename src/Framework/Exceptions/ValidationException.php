<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use RuntimeException;

class ValidationException extends RuntimeException
{
    // Http code - 422 Unprocessable Content
    public function __construct(public array $errors, int $code = 422)
    {
        parent::__construct(code: $code);
    }
}
