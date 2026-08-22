<?php

namespace Detectant\Requests;

use Detectant\Core\Json\JsonSerializableType;
use Detectant\Utils\File;

class CreateScanRequest extends JsonSerializableType
{
    /**
     * @var File $file
     */
    public File $file;

    /**
     * @param array{
     *   file: File,
     * } $values
     */
    public function __construct(
        array $values,
    ) {
        $this->file = $values['file'];
    }
}
