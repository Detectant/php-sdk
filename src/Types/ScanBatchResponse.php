<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;
use Detectant\Core\Types\ArrayType;

class ScanBatchResponse extends JsonSerializableType
{
    /**
     * @var array<ScanBatchResult> $results One outcome per submitted file, in submission order.
     */
    #[JsonProperty('results'), ArrayType([ScanBatchResult::class])]
    public array $results;

    /**
     * @param array{
     *   results: array<ScanBatchResult>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->results = $values['results'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
