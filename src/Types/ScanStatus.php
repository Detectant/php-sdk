<?php

namespace Detectant\Types;

enum ScanStatus: string
{
    case Completed = "completed";
    case Failed = "failed";
}
