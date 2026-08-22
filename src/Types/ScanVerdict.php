<?php

namespace Detectant\Types;

enum ScanVerdict: string
{
    case Clean = "clean";
    case Malicious = "malicious";
    case Suspicious = "suspicious";
    case Unknown = "unknown";
}
