<?php

namespace Detectant\Types;

enum TypeAnalysisConfidence: string
{
    case High = "high";
    case Medium = "medium";
    case Low = "low";
}
