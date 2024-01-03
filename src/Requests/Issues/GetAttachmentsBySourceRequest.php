<?php

namespace Tonning\Linear\Requests\Issues;

use Saloon\Contracts\Body\HasBody;
use Tonning\Linear\Requests\Request;

class GetAttachmentsBySourceRequest extends Request implements HasBody
{
    public function __construct(
        public readonly string $issueId,
        public readonly string $sourceType,
    )
    {
        //
    }

    public function defaultBody(): array
    {
        $query = <<<QUERY
            query Issue(\$issueId: String!, \$attachmentsFilter: AttachmentFilter) {
              issue(id: \$issueId) {
                attachments(filter: \$attachmentsFilter) {
                  nodes { $this->returnNodes }
                }
              }
            }
            QUERY;

        return [
            'query' => $query,
            'variables' => [
                'issueId' => $this->issueId,
                'filter' => [
                    'sourceType' => [
                        'eq' => $this->sourceType
                    ]
                ],
            ]
        ];
    }
}
