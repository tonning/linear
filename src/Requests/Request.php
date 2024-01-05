<?php

namespace Tonning\Linear\Requests;

use Illuminate\Support\Str;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;

abstract class Request extends \Saloon\Http\Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    protected string $returnNodes = '';

    public function return(array|string $nodes): static
    {
        $this->returnNodes = is_array($nodes)
            ? $this->convertArrayToGraphQlSyntax($nodes)
            : $nodes;

        return $this;
    }

    public function resolveEndpoint(): string
    {
        return '';
    }

    private function convertArrayToGraphQlSyntax($fields): string
    {
        return Str::of(json_encode($fields, JSON_PRETTY_PRINT))
            ->replaceMatches('~"\d+":\s~', '')
            ->replace(['"', ':'], '')
            ->replace(['[', ']'], ['{', '}'])
            ->replaceFirst("{", "")
            ->replaceLast("}", "")
            ->toString();
    }
}
