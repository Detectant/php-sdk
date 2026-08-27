<?php

namespace Detectant\Scans\Types;

enum ListScansRequestFailure: string
{
    case Any = "any";
    case None = "none";
    case ScannerUnavailable = "SCANNER_UNAVAILABLE";
    case ContentExpansionLimitExceeded = "CONTENT_EXPANSION_LIMIT_EXCEEDED";
}
