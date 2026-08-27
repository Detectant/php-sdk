<?php

namespace Detectant\Scans\Types;

enum ListScansRequestSourceType: string
{
    case Api = "api";
    case S3 = "s3";
}
