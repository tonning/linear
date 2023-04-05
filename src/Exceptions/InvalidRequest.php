<?php

namespace Tonning\Linear\Exceptions;

use Exception;
use Saloon\Http\Response;

class InvalidRequest extends Exception
{
    public readonly array $errors;

    public static function fromResponse(Response $response, string $message = null)
    {
        $exception = new static($message ?: 'Invalid request');

        $exception->errors = $response->json('errors');

        return $exception;
    }
}
