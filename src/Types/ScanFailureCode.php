<?php

namespace Detectant\Types;

enum ScanFailureCode: string
{
    case ScannerUnavailable = "SCANNER_UNAVAILABLE";
    case ContentExpansionLimitExceeded = "CONTENT_EXPANSION_LIMIT_EXCEEDED";
}
