<?php

namespace Tonning\Linear\Resources\Response;

use Illuminate\Support\LazyCollection;
use Saloon\Http\Response;

class Teams
{
    public readonly LazyCollection $teams;

    public function __construct(public readonly Response $response)
    {
        $this->teams = (new LazyCollection($this->response->json('data.teams.nodes')))
            ->map(fn (array $team) => new Team($team));
    }

    public function __call(string $name, array $arguments)
    {
        return $this->teams->$name(...$arguments);
    }
}
