<?php

namespace Tonning\Linear\Requests\Issues;

use Saloon\Contracts\Body\HasBody;
use Tonning\Linear\Requests\Request;

class UpdateLabelsRequest extends Request implements HasBody
{
    public function __construct(
        public readonly string $issueId,
        public readonly array $labelIds,
    )
    {
        //
    }

    public function defaultBody(): array
    {
        $query = <<<QUERY
            mutation IssueUpdate(\$issueUpdateInput: IssueUpdateInput!, \$issueUpdateId: String!) {
              issueUpdate(input: \$issueUpdateInput, id: \$issueUpdateId) {
                issue { $this->returnNodes }
              }
            }
            QUERY;


        return [
            'query' => $query,
            'variables' => [
                'issueUpdateInput' => [
                    'labelIds' => $this->labelIds
                ],
                'issueUpdateId' => $this->issueId,
            ]
        ];
    }
}
