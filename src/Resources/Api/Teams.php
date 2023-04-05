<?php

namespace Tonning\Linear\Resources\Api;

use Tonning\Linear\Requests\Teams\GetTeamsQueryRequest;
use Tonning\Linear\Resources\Response\Teams as TeamsResource;

class Teams extends ApiResource
{
    public function mine(string|array $nodes = null): TeamsResource
    {
        $request = new GetTeamsQueryRequest();
        $request->return($nodes ?: ['id', 'name']);

        return new TeamsResource($this->api->send($request));
    }
}
