<?php

namespace Detectant\Types;

enum TypeAnalysisReasonCode: string
{
    case MalformedFile = "malformed_file";
    case EncryptedArchive = "encrypted_archive";
    case FileTypeMismatch = "file_type_mismatch";
}
