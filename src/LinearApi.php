<?php

namespace Tonning\Linear;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Tonning\Linear\Resources\Api\Issues;
use Tonning\Linear\Resources\Api\Teams;

class LinearApi extends Connector
{
//    use AlwaysThrowOnErrors;

    public function __construct(string $apiToken)
    {
        $this->withTokenAuth($apiToken);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.linear.app/graphql';
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function issues(): Issues
    {
        return new Issues($this);
    }

    public function teams(): Teams
    {
        return new Teams($this);
    }
}
