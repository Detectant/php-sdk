<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class HealthResponse extends JsonSerializableType
{
    /**
     * @var value-of<HealthResponseStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @param array{
     *   status: value-of<HealthResponseStatus>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->status = $values['status'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
