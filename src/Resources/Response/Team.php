<?php

namespace Tonning\Linear\Resources\Response;

use Throwable;
use Tonning\Linear\Exceptions\FieldNotFound;

class Team
{
    public function __construct(public readonly array $team)
    {
    }

    /**
     * @throws FieldNotFound|Throwable
     */
    public function __get(string $name)
    {
        throw_if(! isset($this->team[$name]), FieldNotFound::class, "$name not found or returned from API call.");

        return $this->team[$name];
    }
}
