<?php

namespace Tonning\Linear\Requests\Issues;

use Saloon\Contracts\Body\HasBody;
use Tonning\Linear\Requests\Request;

class GetIssuesByAttachmentUrlRequest extends Request implements HasBody
{
    public function __construct(
        public readonly string $url,
    )
    {
        //
    }

    public function defaultBody(): array
    {
        $query = <<<QUERY
            query IssueByAttachmentUrl(\$url: String!) {
              attachmentsForURL(url: \$url) {
                nodes { $this->returnNodes }
              }
            }
            QUERY;

        return [
            'query' => $query,
            'variables' => [
                'url' => $this->url,
            ]
        ];
    }
}
