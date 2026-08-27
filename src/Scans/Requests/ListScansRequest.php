<?php

namespace Detectant\Scans\Requests;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Scans\Types\ListScansRequestSourceType;
use Detectant\Scans\Types\ListScansRequestFailure;

class ListScansRequest extends JsonSerializableType
{
    /**
     * @var ?int $limit Maximum results to return. Values above 200 are capped at 200; omission uses 50.
     */
    public ?int $limit;

    /**
     * @var ?string $cursor Opaque cursor returned as `next_cursor` by a previous request.
     */
    public ?string $cursor;

    /**
     * @var ?string $verdict Case-sensitive PostgreSQL `LIKE` fragment matched against the stored verdict; `%` and `_` act as wildcards.
     */
    public ?string $verdict;

    /**
     * @var ?string $scanId Case-insensitive fragment matched against the scan identifier.
     */
    public ?string $scanId;

    /**
     * @var ?value-of<ListScansRequestSourceType> $sourceType Return direct API scans or scans submitted by an S3 integration.
     */
    public ?string $sourceType;

    /**
     * @var ?string $storageIntegrationId Return scans submitted by this S3 integration.
     */
    public ?string $storageIntegrationId;

    /**
     * @var ?value-of<ListScansRequestFailure> $failure Return scans by failure presence or customer-facing failure code.
     */
    public ?string $failure;

    /**
     * @var ?string $filename Case-sensitive PostgreSQL `LIKE` fragment matched against the stored filename; `%` and `_` act as wildcards.
     */
    public ?string $filename;

    /**
     * @var ?string $engineSignature Case-sensitive PostgreSQL `LIKE` fragment matched against the stored engine signature; `%` and `_` act as wildcards.
     */
    public ?string $engineSignature;

    /**
     * @var ?string $detectionRule Case-sensitive PostgreSQL `LIKE` fragment matched against stored detection rules; `%` and `_` act as wildcards.
     */
    public ?string $detectionRule;

    /**
     * @param array{
     *   limit?: ?int,
     *   cursor?: ?string,
     *   verdict?: ?string,
     *   scanId?: ?string,
     *   sourceType?: ?value-of<ListScansRequestSourceType>,
     *   storageIntegrationId?: ?string,
     *   failure?: ?value-of<ListScansRequestFailure>,
     *   filename?: ?string,
     *   engineSignature?: ?string,
     *   detectionRule?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->limit = $values['limit'] ?? null;
        $this->cursor = $values['cursor'] ?? null;
        $this->verdict = $values['verdict'] ?? null;
        $this->scanId = $values['scanId'] ?? null;
        $this->sourceType = $values['sourceType'] ?? null;
        $this->storageIntegrationId = $values['storageIntegrationId'] ?? null;
        $this->failure = $values['failure'] ?? null;
        $this->filename = $values['filename'] ?? null;
        $this->engineSignature = $values['engineSignature'] ?? null;
        $this->detectionRule = $values['detectionRule'] ?? null;
    }
}
