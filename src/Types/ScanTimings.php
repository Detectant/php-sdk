<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class ScanTimings extends JsonSerializableType
{
    /**
     * @var float $fileTypeMs
     */
    #[JsonProperty('file_type_ms')]
    public float $fileTypeMs;

    /**
     * @var float $malwareScanMs
     */
    #[JsonProperty('malware_scan_ms')]
    public float $malwareScanMs;

    /**
     * @param array{
     *   fileTypeMs: float,
     *   malwareScanMs: float,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->fileTypeMs = $values['fileTypeMs'];
        $this->malwareScanMs = $values['malwareScanMs'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
