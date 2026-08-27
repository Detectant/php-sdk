<?php

namespace Detectant\Types;

enum ScanSourceType: string
{
    case Api = "api";
    case S3 = "s3";
}
