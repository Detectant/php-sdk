<?php

namespace Detectant\Types;

enum TypeAnalysisReasonCode: string
{
    case MalformedFile = "malformed_file";
    case EncryptedArchive = "encrypted_archive";
    case UnsupportedArchive = "unsupported_archive";
    case ContentExpansionLimitExceeded = "content_expansion_limit_exceeded";
    case FileTypeMismatch = "file_type_mismatch";
}
