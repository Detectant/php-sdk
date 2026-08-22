<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;
use Detectant\Core\Types\ArrayType;

class ApiError extends JsonSerializableType
{
    /**
     * @var string $code Stable machine-readable error code.
     */
    #[JsonProperty('code')]
    public string $code;

    /**
     * @var string $message Human-readable error message.
     */
    #[JsonProperty('message')]
    public string $message;

    /**
     * @var array<string, string> $details Context such as the ID of a failed stored scan. Empty when no context applies.
     */
    #[JsonProperty('details'), ArrayType(['string' => 'string'])]
    public array $details;

    /**
     * @param array{
     *   code: string,
     *   message: string,
     *   details: array<string, string>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->code = $values['code'];
        $this->message = $values['message'];
        $this->details = $values['details'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
