<?php

namespace Tonning\Linear\Requests\Issues;

use Saloon\Contracts\Body\HasBody;
use Tonning\Linear\Requests\Request;

class CreateAttachmentRequest extends Request implements HasBody
{
    public function __construct(
        public readonly string $issueId,
        public readonly string $url,
        public readonly string $title,
        public readonly ?string $subtitle,
        public readonly ?string $id,
        public readonly ?array $metadata,
    )
    {
        //
    }

    public function defaultBody(): array
    {
        $query = <<<QUERY
            mutation AttachmentCreate(\$attachmentCreateInput: AttachmentCreateInput!) {
              attachmentCreate(input: \$attachmentCreateInput) {
                success
                attachment {
                  $this->returnNodes
                }
              }
            }
            QUERY;


        return [
            'query' => $query,
            'variables' => [
                'attachmentCreateInput' => [
                    'issueId' => $this->issueId,
                    'url' => $this->url,
                    'title' => $this->title,
                    'subtitle' => $this->subtitle,
                    'metadata' => $this->metadata,
                ],
            ],
        ];
    }
}
