<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class ScanSource extends JsonSerializableType
{
    /**
     * @var value-of<ScanSourceType> $type
     */
    #[JsonProperty('type')]
    public string $type;

    /**
     * @var ?string $integrationId S3 integration identifier, or `null` for direct API scans.
     */
    #[JsonProperty('integration_id')]
    public ?string $integrationId;

    /**
     * @var ?string $integrationName S3 integration name, or `null` for direct API scans.
     */
    #[JsonProperty('integration_name')]
    public ?string $integrationName;

    /**
     * @param array{
     *   type: value-of<ScanSourceType>,
     *   integrationId?: ?string,
     *   integrationName?: ?string,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->type = $values['type'];
        $this->integrationId = $values['integrationId'] ?? null;
        $this->integrationName = $values['integrationName'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
