<?php

namespace Tonning\Linear\Requests;

use Saloon\Contracts\Body\HasBody;

abstract class MutationRequest extends Request implements HasBody
{
    abstract public function graphQuery(): string;
    abstract public function inputObjectType(): string;
    abstract public function inputObjectBody(): array;

    public function defaultBody(): array
    {
        $requestGraphQuery = $this->graphQuery();
        $inputObject = $this->inputObjectType();

        $query = <<<QUERY
            mutation (\$input: $inputObject) {
                $requestGraphQuery
            }
        QUERY;

        return [
            'query' => $query,
            'variables' => [
                'input' => $this->inputObjectBody(),
            ]
        ];
    }
}
