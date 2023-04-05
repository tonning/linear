<?php

namespace Tonning\Linear\Resources\Api;

use JsonException;
use Saloon\Http\Connector;
use Saloon\Http\Response;
use Throwable;
use Tonning\Linear\Exceptions\InvalidRequest;

class ApiResource
{
    public function __construct(protected Connector $api)
    {
    }

    /**
     * @throws Throwable
     * @throws JsonException
     */
    public function validate(Response $response): bool
    {
        if (! blank($response->json('errors'))) {
            throw InvalidRequest::fromResponse($response);
        }

        return true;
    }
}
