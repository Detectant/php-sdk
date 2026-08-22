<?php

namespace Detectant\Requests;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Utils\File;

class CreateScanBatchRequest extends JsonSerializableType
{
    /**
     * @var array<File> $files
     */
    public array $files;

    /**
     * @param array{
     *   files: array<File>,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->files = $values['files'];
    }
}
