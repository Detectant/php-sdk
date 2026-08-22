<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class ErrorResponse extends JsonSerializableType
{
    /**
     * @var ApiError $error
     */
    #[JsonProperty('error')]
    public ApiError $error;

    /**
     * @param array{
     *   error: ApiError,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->error = $values['error'];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
