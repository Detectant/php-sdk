<?php

namespace Detectant\Scans\Requests;

use Detectant\Core\Json\JsonSerializableType;

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
        $this->filename = $values['filename'] ?? null;
        $this->engineSignature = $values['engineSignature'] ?? null;
        $this->detectionRule = $values['detectionRule'] ?? null;
    }
}
