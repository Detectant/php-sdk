<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;
use DateTime;
use Detectant\Core\Types\Date;
use Detectant\Core\Types\ArrayType;

class Scan extends JsonSerializableType
{
    /**
     * @var string $id Server-generated scan identifier.
     */
    #[JsonProperty('id')]
    public string $id;

    /**
     * @var DateTime $createdAt
     */
    #[JsonProperty('created_at'), Date(Date::TYPE_DATETIME)]
    public DateTime $createdAt;

    /**
     * @var value-of<ScanStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var value-of<ScanVerdict> $verdict
     */
    #[JsonProperty('verdict')]
    public string $verdict;

    /**
     * @var string $filename Filename supplied by the multipart upload.
     */
    #[JsonProperty('filename')]
    public string $filename;

    /**
     * @var string $sha256
     */
    #[JsonProperty('sha256')]
    public string $sha256;

    /**
     * @var int $sizeBytes
     */
    #[JsonProperty('size_bytes')]
    public int $sizeBytes;

    /**
     * @var float $durationMs
     */
    #[JsonProperty('duration_ms')]
    public float $durationMs;

    /**
     * @var ?ScanFailure $failure Failure information, or `null` when the scan completed.
     */
    #[JsonProperty('failure')]
    public ?ScanFailure $failure;

    /**
     * @var array<string> $detections Detection names reported for the file. Empty when no threats were detected.
     */
    #[JsonProperty('detections'), ArrayType(['string'])]
    public array $detections;

    /**
     * @var TypeAnalysis $typeAnalysis
     */
    #[JsonProperty('type_analysis')]
    public TypeAnalysis $typeAnalysis;

    /**
     * @param array{
     *   id: string,
     *   createdAt: DateTime,
     *   status: value-of<ScanStatus>,
     *   verdict: value-of<ScanVerdict>,
     *   filename: string,
     *   sha256: string,
     *   sizeBytes: int,
     *   durationMs: float,
     *   detections: array<string>,
     *   typeAnalysis: TypeAnalysis,
     *   failure?: ?ScanFailure,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->id = $values['id'];
        $this->createdAt = $values['createdAt'];
        $this->status = $values['status'];
        $this->verdict = $values['verdict'];
        $this->filename = $values['filename'];
        $this->sha256 = $values['sha256'];
        $this->sizeBytes = $values['sizeBytes'];
        $this->durationMs = $values['durationMs'];
        $this->failure = $values['failure'] ?? null;
        $this->detections = $values['detections'];
        $this->typeAnalysis = $values['typeAnalysis'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
