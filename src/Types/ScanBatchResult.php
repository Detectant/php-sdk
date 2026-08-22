<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class ScanBatchResult extends JsonSerializableType
{
    /**
     * @var int $index Zero-based position of the submitted file.
     */
    #[JsonProperty('index')]
    public int $index;

    /**
     * @var string $filename Filename supplied by the multipart part.
     */
    #[JsonProperty('filename')]
    public string $filename;

    /**
     * @var int $httpStatus HTTP status that the equivalent single-file request would return.
     */
    #[JsonProperty('http_status')]
    public int $httpStatus;

    /**
     * @var ?Scan $scan Stored scan result, including its scan ID, or null when validation failed before a scan was created.
     */
    #[JsonProperty('scan')]
    public ?Scan $scan;

    /**
     * @var ?ApiError $error Per-file validation or scanning error, or null when the scan completed.
     */
    #[JsonProperty('error')]
    public ?ApiError $error;

    /**
     * @param array{
     *   index: int,
     *   filename: string,
     *   httpStatus: int,
     *   scan?: ?Scan,
     *   error?: ?ApiError,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->index = $values['index'];
        $this->filename = $values['filename'];
        $this->httpStatus = $values['httpStatus'];
        $this->scan = $values['scan'] ?? null;
        $this->error = $values['error'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
