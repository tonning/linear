<?php

namespace Tonning\Linear\Resources\Api;

use JsonException;
use ReflectionException;
use Illuminate\Support\Arr;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Throwable;
use Tonning\Linear\Requests\Issues\AddAttachmentLinkUrlRequest;
use Tonning\Linear\Requests\Issues\CreateAttachmentRequest;
use Tonning\Linear\Requests\Issues\GetAttachmentsRequest;
use Tonning\Linear\Requests\Issues\UpdateLabelsRequest;
use Tonning\Linear\Requests\Issues\CreateIssueRequest;
use Tonning\Linear\Resources\Response\Issue;
use Tonning\Linear\Requests\Issues\GetAttachmentsBySourceRequest;
use Tonning\Linear\Requests\Issues\GetIssuesByAttachmentUrlRequest;

class Issues extends ApiResource
{
    /**
     * @throws Throwable
     * @throws JsonException
     */
    public function create(
        string $teamId,
        string $title,
        ?string $description = null,
        string|array|null $returnNodes = null
    ): Issue
    {
        $request = new CreateIssueRequest(
            teamId: $teamId,
            title: $title,
            description: $description,
        );

        $request->return($returnNodes ?: ['title', 'id', 'identifier']);

        $response = $this->api->send($request);

        $this->validate($response);

        return new Issue($response->json('data.issueCreate.issue'));
    }

    /**
     * @throws InvalidResponseClassException
     * @throws Throwable
     * @throws ReflectionException
     * @throws PendingRequestException
     * @throws JsonException
     */
    public function updateLabels(string $issueId, array $labelIds, string|array|null $returnNodes = null): Issue
    {
        $request = new UpdateLabelsRequest(issueId: $issueId, labelIds: $labelIds);

        $request->return($returnNodes ?: ['title', 'id', 'identifier']);

        $response = $this->api->send($request);

        $this->validate($response);

        return new Issue($response->json('data.issueUpdate.issue'));
    }

    public function attachLink(string $issueId, string $url, ?string $title = null, string|array|null $returnNodes = null)
    {
        $request = new AddAttachmentLinkUrlRequest(issueId: $issueId, url: $url, title: $title);

        $request->return($returnNodes ?: ['success']);

        $response = $this->api->send($request);

        $this->validate($response);

        return $response->json('data.attachmentLinkURL');
    }

    public function createAttachment(string $issueId, string $url, string $title, string $subtitle = null, string $id = null, array $metadata = null, string|array|null $returnNodes = null)
    {
        $request = new CreateAttachmentRequest($issueId, $url, $title, $subtitle, $id, $metadata);

        $request->return($returnNodes ?: ['url', 'id', 'title', 'subtitle', 'metadata']);

        $response = $this->api->send($request);

        $this->validate($response);

        return $response->json('data.attachmentCreate.attachment');
    }

    public function getAttachments(string $issueId, string $attachmentTitle, string|array|null $returnNodes = null)
    {
        $request = new GetAttachmentsRequest($issueId, $attachmentTitle);

        $request->return($returnNodes ?: ['url', 'id', 'title', 'subtitle', 'metadata']);

        $response = $this->api->send($request);

        $this->validate($response);

        return $response->json('data.issue.attachments.nodes');
    }

    public function getAttachmentsBySource(string $issueId, string $source, string|array|null $returnNodes = null)
    {
        $request = new GetAttachmentsBySourceRequest($issueId, $source);

        $request->return($returnNodes ?: ['url', 'id', 'title', 'subtitle', 'metadata']);

        $response = $this->api->send($request);

        $this->validate($response);

        return $response->json('data.issue.attachments.nodes');
    }

    public function getIssuesByAttachmentUrl(string $url, string|array|null $returnNodes = null)
    {
        $request = new GetIssuesByAttachmentUrlRequest($url);

        $request->return(['issue' => Arr::wrap($returnNodes ?: 'identifier')]);

        $response = $this->api->send($request);

        $this->validate($response);

        return $response->json('data.attachmentsForURL.nodes');
    }
}
