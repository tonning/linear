<?php

namespace Tonning\Linear\Requests\Issues;

use Saloon\Contracts\Body\HasBody;
use Tonning\Linear\Requests\Request;

class AddAttachmentLinkUrlRequest extends Request implements HasBody
{
    public function __construct(
        public readonly string $issueId,
        public readonly string $url,
        public readonly ?string $title,
    )
    {
        //
    }

    public function defaultBody(): array
    {
        $query = <<<QUERY
            mutation AttachmentLinkURL(\$issueId: String!, \$url: String!, \$title: String) {
              attachmentLinkURL(issueId: \$issueId, url: \$url, title: \$title) {
                success
              }
            }
            QUERY;


        return [
            'query' => $query,
            'variables' => [
                'issueId' => $this->issueId,
                'url' => $this->url,
                'title' => $this->title,
            ]
        ];
    }
}
