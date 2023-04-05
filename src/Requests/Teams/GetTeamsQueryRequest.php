<?php

namespace Tonning\Linear\Requests\Teams;

use Tonning\Linear\Requests\QueryRequest;

class GetTeamsQueryRequest extends QueryRequest
{
    public function graphQuery(): string
    {
        return <<<QUERY
            teams {
                nodes {
                    $this->returnNodes
                }
            }
        QUERY;
    }
}
