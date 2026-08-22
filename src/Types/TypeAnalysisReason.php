<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class TypeAnalysisReason extends JsonSerializableType
{
    /**
     * @var value-of<TypeAnalysisReasonCode> $code
     */
    #[JsonProperty('code')]
    public string $code;

    /**
     * @var ?string $claimed
     */
    #[JsonProperty('claimed')]
    public ?string $claimed;

    /**
     * @var ?string $detected
     */
    #[JsonProperty('detected')]
    public ?string $detected;

    /**
     * @param array{
     *   code: value-of<TypeAnalysisReasonCode>,
     *   claimed?: ?string,
     *   detected?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->code = $values['code'];
        $this->claimed = $values['claimed'] ?? null;
        $this->detected = $values['detected'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
