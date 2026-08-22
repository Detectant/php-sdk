<?php

namespace Detectant\Types;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Core\Json\JsonProperty;

class TypeAnalysis extends JsonSerializableType
{
    /**
     * @var TypeDeclaration $declared
     */
    #[JsonProperty('declared')]
    public TypeDeclaration $declared;

    /**
     * @var TypeIdentification $identified
     */
    #[JsonProperty('identified')]
    public TypeIdentification $identified;

    /**
     * @var value-of<TypeAnalysisStatus> $status
     */
    #[JsonProperty('status')]
    public string $status;

    /**
     * @var ?bool $structurallyValid
     */
    #[JsonProperty('structurally_valid')]
    public ?bool $structurallyValid;

    /**
     * @var value-of<TypeAnalysisConfidence> $confidence
     */
    #[JsonProperty('confidence')]
    public string $confidence;

    /**
     * @var ?TypeAnalysisReason $reason
     */
    #[JsonProperty('reason')]
    public ?TypeAnalysisReason $reason;

    /**
     * @param array{
     *   declared: TypeDeclaration,
     *   identified: TypeIdentification,
     *   status: value-of<TypeAnalysisStatus>,
     *   confidence: value-of<TypeAnalysisConfidence>,
     *   structurallyValid?: ?bool,
     *   reason?: ?TypeAnalysisReason,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->declared = $values['declared'];
        $this->identified = $values['identified'];
        $this->status = $values['status'];
        $this->structurallyValid = $values['structurallyValid'] ?? null;
        $this->confidence = $values['confidence'];
        $this->reason = $values['reason'] ?? null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toJson();
    }
}
