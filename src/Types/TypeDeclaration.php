<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class TypeDeclaration extends JsonSerializableType
{
    /**
     * @var ?string $extension Raw extension from the uploaded filename, without the leading dot.
     */
    #[JsonProperty('extension')]
    public ?string $extension;

    /**
     * @var ?string $mime Normalized MIME type declared by the multipart part.
     */
    #[JsonProperty('mime')]
    public ?string $mime;

    /**
     * @param array{
     *   extension?: ?string,
     *   mime?: ?string,
     * } $values
     */
    public function __construct(
        array $values = [],
    ) {
        $this->extension = $values['extension'] ?? null;
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
