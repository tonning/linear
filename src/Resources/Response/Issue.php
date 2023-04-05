<?php

namespace Tonning\Linear\Resources\Response;

use Throwable;
use Tonning\Linear\Exceptions\FieldNotFound;

class Issue
{
    public function __construct(public readonly array $issue)
    {
    }

    /**
     * @throws FieldNotFound|Throwable
     */
    public function __get(string $name)
    {
        throw_if(! isset($this->issue[$name]), FieldNotFound::class, "$name not found or returned from API call.");

        return $this->issue[$name];
    }
}
