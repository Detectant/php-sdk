<?php

namespace Detectant\Types;

enum TypeAnalysisStatus: string
{
    case Match_ = "match";
    case Compatible = "compatible";
    case Mismatch = "mismatch";
    case Malformed = "malformed";
    case Unscannable = "unscannable";
    case Unknown = "unknown";
}
