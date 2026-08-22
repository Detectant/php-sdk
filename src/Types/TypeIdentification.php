<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class TypeIdentification extends JsonSerializableType
{
    /**
     * @var ?string $format Canonical format identified from file content.
     */
    #[JsonProperty('format')]
    public ?string $format;

    /**
     * @var ?string $mime Canonical MIME type identified from file content.
     */
    #[JsonProperty('mime')]
    public ?string $mime;

    /**
     * @param array{
     *   format?: ?string,
     *   mime?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->format = $values['format'] ?? null;
        $this->mime = $values['mime'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
