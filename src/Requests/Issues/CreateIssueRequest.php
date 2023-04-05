<?php

namespace Tonning\Linear\Requests\Issues;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Traits\Body\HasJsonBody;
use Tonning\Linear\Requests\MutationRequest;

class CreateIssueRequest extends MutationRequest implements HasBody
{
    public function __construct(
        public readonly string $teamId,
        public readonly string $title,
        public readonly ?string $description = null
    )
    {
        //
    }

    public function graphQuery(): string
    {
        return <<<QUERY
            issueCreate(input: \$input) {
                issue { $this->returnNodes }
            }
        QUERY;
    }

    public function inputObjectType(): string
    {
        return 'IssueCreateInput!';
    }

    public function inputObjectBody(): array
    {
        return [
            'teamId' => $this->teamId,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
