<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;
use Detectant\Core\Types\ArrayType;

class ScanList extends JsonSerializableType
{
    /**
     * @var array<Scan> $items Scan records. Empty when the account has no scans.
     */
    #[JsonProperty('items'), ArrayType([Scan::class])]
    public array $items;

    /**
     * @var ?string $nextCursor Opaque cursor for the next page, or `null` when no next page exists.
     */
    #[JsonProperty('next_cursor')]
    public ?string $nextCursor;

    /**
     * @param array{
     *   items: array<Scan>,
     *   nextCursor?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->items = $values['items'];
        $this->nextCursor = $values['nextCursor'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
